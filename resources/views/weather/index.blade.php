@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full glass mb-6 animate-float">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3">Weather App</h1>
            <p class="text-white/80 text-lg">Get real-time weather updates for any city</p>
        </div>

        @if (session('error'))
        <div class="glass rounded-2xl p-4 mb-6 border-l-4 border-red-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-white">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="glass rounded-2xl p-4 mb-6 border-l-4 border-red-400">
            @foreach ($errors->all() as $error)
            <p class="text-white">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="glass rounded-3xl p-8 mb-8">
            <form action="{{ route('weather.get') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <div class="mb-5">
                    <label for="city" class="block text-white/90 font-semibold mb-2 text-sm uppercase tracking-wide">City</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </span>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required
                            class="input-modern w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none"
                            placeholder="Enter city name">
                    </div>
                </div>
                <div class="mb-6">
                    <label for="country" class="block text-white/90 font-semibold mb-2 text-sm uppercase tracking-wide">Country Code</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <input type="text" id="country" name="country" value="{{ old('country') }}" required
                            class="input-modern w-full pl-12 pr-4 py-4 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none uppercase"
                            maxlength="2" placeholder="e.g. US, PH, UK" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <button type="submit"
                    class="btn-gradient w-full text-white font-bold py-4 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-white/30 disabled:opacity-70 disabled:cursor-not-allowed"
                    x-bind:disabled="loading">
                    <span x-show="!loading" class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Get Weather
                    </span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    </span>
                </button>
            </form>
        </div>

        @if($recentSearches->count() > 0)
        <div class="glass rounded-3xl p-6">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Searches
            </h2>
            <ul class="space-y-2">
                @foreach ($recentSearches as $search)
                <li>
                    <a href="{{ route('weather.saved', $search->id) }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 group">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center mr-3 group-hover:bg-white/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                            <span class="text-white font-medium">{{ $search->city }}, {{ $search->country }}</span>
                        </div>
                        <span class="text-white/60 text-sm">{{ $search->created_at->diffForHumans() }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection
