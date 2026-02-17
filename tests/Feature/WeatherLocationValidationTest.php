<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherLocationValidationTest extends TestCase
{
    public function test_it_returns_error_when_city_country_combination_does_not_exist(): void
    {
        Http::fake([
            'https://geocoding-api.open-meteo.com/v1/search*' => Http::response([
                'results' => [
                    [
                        'name' => 'davao',
                        'country_code' => 'PH',
                    ],
                ],
            ], 200),
            '*' => Http::response([], 500),
        ]);

        $response = $this->from('/')->post(route('weather.get'), [
            'city' => 'new york',
            'country' => 'ph',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('error', "Location 'Davao City, US' does not exist.");

        Http::assertSentCount(1);
        Http::assertSent(function (HttpRequest $request) {
            return str_contains((string) $request->url(), 'geocoding-api.open-meteo.com');
        });
    }
}
