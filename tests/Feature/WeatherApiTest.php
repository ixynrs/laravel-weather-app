<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class WeatherApiTest extends TestCase
{
    public function test_tomorrow_io_api_returns_weather_data()
    {
        $apiKey = config('services.tomorrow.key');

        if (empty($apiKey)) {
            $this->markTestSkipped('TOMORROW_API_KEY is not set in .env');
        }

        $response = Http::timeout(15)->get('https://api.tomorrow.io/v4/weather/forecast', [
            'apikey' => $apiKey,
            'location' => 'panabo PH',
        ]);

        $this->assertTrue($response->successful(), 'API request failed: ' . $response->body());

        $data = $response->json();

        $this->assertArrayHasKey('timelines', $data);
        $this->assertArrayHasKey('daily', $data['timelines']);
        $this->assertArrayHasKey('minutely', $data['timelines']);

        $currentWeather = $data['timelines']['minutely'][0] ?? null;
        $this->assertNotNull($currentWeather);
        $this->assertArrayHasKey('values', $currentWeather);
        $this->assertArrayHasKey('temperature', $currentWeather['values']);

        $this->assertGreaterThanOrEqual(1, count($data['timelines']['daily']));
    }

    public function test_api_key_is_configured()
    {
        $apiKey = config('services.tomorrow.key');

        $this->assertNotEmpty($apiKey, 'TOMORROW_API_KEY is not configured in services.tomorrow.key');
    }

    public function test_geocoding_returns_error_for_invalid_city_country_combination()
    {
        $response = Http::timeout(15)->get('https://geocoding-api.open-meteo.com/v1/search', [
            'name' => 'davao',
            'count' => 10,
            'language' => 'en',
            'format' => 'json',
        ]);

        $this->assertTrue($response->successful());

        $results = $response->json('results', []);

        $matchedLocation = collect($results)->first(function ($result) {
            return strtoupper($result['country_code'] ?? '') === 'US';
        });

        $this->assertNull($matchedLocation, 'Davao should not exist in US');
    }

    public function test_geocoding_finds_valid_city_country_combination()
    {
        $response = Http::timeout(15)->get('https://geocoding-api.open-meteo.com/v1/search', [
            'name' => 'davao',
            'count' => 10,
            'language' => 'en',
            'format' => 'json',
        ]);

        $this->assertTrue($response->successful());

        $results = $response->json('results', []);

        $matchedLocation = collect($results)->first(function ($result) {
            return strtoupper($result['country_code'] ?? '') === 'PH';
        });

        $this->assertNotNull($matchedLocation, 'Davao should exist in PH');
        $this->assertArrayHasKey('latitude', $matchedLocation);
        $this->assertArrayHasKey('longitude', $matchedLocation);
    }
}
