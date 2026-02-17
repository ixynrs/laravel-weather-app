<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    private $apiKey;

    private $baseUrl = 'https://api.tomorrow.io/v4/';

    private $geocodingUrl = 'https://geocoding-api.open-meteo.com/v1/search';

    public function __construct()
    {
        $this->apiKey = config('services.tomorrow.key');
    }

    public function index()
    {
        $recentSearches = SearchHistory::orderBy('created_at', 'desc')->take(5)->get();

        return view('weather.index', compact('recentSearches'));
    }

    public function getWeather(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'country' => 'required|string|size:2|alpha',
        ]);

        $city = trim((string) $request->input('city'));
        $country = strtoupper(trim((string) $request->input('country')));

        try {
            $location = $this->resolveLocation($city, $country);
            $cacheKey = 'weather_v2_'.md5(strtolower($city).'|'.$country.'|'.$location['latitude'].'|'.$location['longitude']);

            if (Cache::has($cacheKey)) {
                $weatherData = Cache::get($cacheKey);
            } else {
                $apiData = $this->fetchWeatherForecast(
                    $location['latitude'],
                    $location['longitude'],
                    $city,
                    $country
                );

                $currentWeather = $apiData['timelines']['minutely'][0] ?? $apiData['timelines']['hourly'][0] ?? null;
                $forecast = array_slice($apiData['timelines']['daily'] ?? [], 0, 5);

                $weatherData = [
                    'current' => $currentWeather,
                    'forecast' => $forecast,
                ];

                Cache::put($cacheKey, $weatherData, now()->addMinutes(30));

                SearchHistory::create([
                    'city' => $city,
                    'country' => $country,
                    'weather_data' => $weatherData,
                ]);
            }

            return view('weather.result', compact('weatherData', 'city', 'country'));
        } catch (ConnectionException $e) {
            Log::error('API connection failed: '.$e->getMessage());

            return back()->withInput()->withError('Unable to fetch weather data. The weather service might be unavailable.');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('API request failed: '.$e->getMessage());

            return back()->withInput()->withError('Unable to fetch weather data. The weather service might be unavailable.');
        } catch (\Exception $e) {
            Log::error('Unexpected error: '.$e->getMessage());

            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, 'does not exist')) {
                return back()->withInput()->with('error', $errorMessage);
            }

            if (str_contains($errorMessage, 'validate location')) {
                return back()->withInput()->withError('Unable to validate location. Please try again later.');
            }

            return back()->withInput()->withError('An unexpected error occurred. Please try again later.');
        }
    }

    public function showSavedWeather($id)
    {
        $searchHistory = SearchHistory::findOrFail($id);
        $weatherData = $searchHistory->weather_data;
        $city = $searchHistory->city;
        $country = $searchHistory->country;

        return view('weather.result', compact('weatherData', 'city', 'country'));
    }

    private function resolveLocation(string $city, string $country): array
    {
        $response = Http::timeout(15)->get($this->geocodingUrl, [
            'name' => $city,
            'count' => 10,
            'language' => 'en',
            'format' => 'json',
        ]);

        if (! $response->successful()) {
            throw new \Exception('Unable to validate location right now.');
        }

        $results = $response->json('results', []);

        $matchedLocation = collect($results)->first(function ($result) use ($country) {
            return strtoupper($result['country_code'] ?? '') === $country;
        });

        if (! $matchedLocation || ! isset($matchedLocation['latitude'], $matchedLocation['longitude'])) {
            throw new \Exception("Location '{$city}, {$country}' does not exist.");
        }

        return [
            'latitude' => (float) $matchedLocation['latitude'],
            'longitude' => (float) $matchedLocation['longitude'],
        ];
    }

    private function fetchWeatherForecast(float $latitude, float $longitude, string $city, string $country): array
    {
        $response = Http::timeout(15)->get($this->baseUrl.'weather/forecast', [
            'apikey' => $this->apiKey,
            'location' => "{$latitude},{$longitude}",
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        $this->handleApiError($response, $city, $country);

        return [];
    }

    private function handleApiError($response, $city, $country)
    {
        $statusCode = $response->status();
        $body = $response->json();

        if ($statusCode === 400 || $statusCode === 404 || $statusCode === 422) {
            $errorMessage = $body['message'] ?? $response->body();
            if (
                str_contains(strtolower($errorMessage), 'location') ||
                str_contains(strtolower($errorMessage), 'not found') ||
                str_contains(strtolower($errorMessage), 'invalid')
            ) {
                throw new \Exception("Location '{$city}, {$country}' does not exist.");
            }
        }

        throw new \Exception('Failed to fetch weather data: '.($body['message'] ?? $response->body()));
    }
}
