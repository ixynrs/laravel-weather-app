<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', [WeatherController::class, 'index'])->name('home');
Route::post('/weather', [WeatherController::class, 'getWeather'])->name('weather.get');
Route::get('/weather/{id}', [WeatherController::class, 'showSavedWeather'])->name('weather.saved');
