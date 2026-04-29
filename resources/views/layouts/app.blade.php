<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'QR Food Ordering') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts & Styles (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased" style="background:#0f1117; color:#e2e8f0;">
        <div class="min-h-screen" style="background:#0f1117;">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header style="background:#1a1d27; border-bottom:1px solid rgba(255,255,255,0.06);">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="alert-success mb-6 fade-in-up">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-error mb-6 fade-in-up">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
