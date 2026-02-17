@extends('layouts.app')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center px-6 py-2 rounded-full glass mb-4">
                <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-white font-semibold">{{ $city }}, {{ $country }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white">Weather Results</h1>
        </div>

        <div class="glass-dark rounded-3xl p-6 md:p-8 mb-8 shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Current Weather</h2>
                <span class="text-sm text-gray-500">Updated just now</span>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-white/80">Temperature</span>
                        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ round($weatherData['current']['values']['temperature'] ?? 0) }}°C</p>
                </div>

                <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-white/80">Feels Like</span>
                        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ round($weatherData['current']['values']['temperatureApparent'] ?? 0) }}°C</p>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-green-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-white/80">Wind Speed</span>
                        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ round($weatherData['current']['values']['windSpeed'] ?? 0) }} <span class="text-lg">m/s</span></p>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-white/80">Humidity</span>
                        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ $weatherData['current']['values']['humidity'] ?? 0 }}<span class="text-lg">%</span></p>
                </div>
            </div>
        </div>

        <div class="glass-dark rounded-3xl p-6 md:p-8 mb-8 shadow-2xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                5-Day Forecast
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                @foreach ($weatherData['forecast'] as $day)
                <div class="bg-gradient-to-b from-white to-gray-50 rounded-2xl p-4 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="text-center mb-3">
                        <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($day['time'])->format('D') }}</p>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($day['time'])->format('M d') }}</p>
                    </div>
                    
                    <div class="flex justify-center mb-3">
                        @php
                        $maxTemp = round($day['values']['temperatureMax'] ?? 0);
                        $rain = round($day['values']['rainAccumulationSum'] ?? 0, 1);
                        @endphp
                        @if($rain > 5)
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                        @elseif($maxTemp > 30)
                        <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                        @endif
                    </div>
                    
                    <div class="text-center space-y-1">
                        <p class="text-lg font-bold text-indigo-600">{{ $maxTemp }}°</p>
                        <p class="text-sm text-gray-500">{{ round($day['values']['temperatureMin'] ?? 0) }}°</p>
                        <div class="flex items-center justify-center text-xs text-blue-500">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z"></path>
                            </svg>
                            {{ $rain }}mm
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 rounded-xl glass text-white font-semibold hover:bg-white/30 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Search
            </a>
        </div>
    </div>
</div>
@endsection
