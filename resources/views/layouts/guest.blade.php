<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-bali-cream">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                     alt="Bali Resort Dining" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-bali-leaf/80 to-bali-wood/80"></div>
            </div>

            <div class="relative z-10 w-full px-4 sm:px-0 sm:max-w-md mt-6">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl overflow-hidden rounded-[2rem] sm:rounded-2xl p-8 sm:p-10">
                    <div class="flex justify-center mb-8">
                        <a href="/" class="flex flex-col items-center">
                            <img src="{{ asset('img/logo.png') }}" alt="Amanuba Logo" class="h-16 sm:h-20 w-auto mb-4 drop-shadow-2xl transition-transform hover:scale-105 duration-300">
                            <h1 class="text-2xl font-bold text-white tracking-[0.3em] mb-1">AMANUBA</h1>
                            <p class="text-[10px] uppercase tracking-[0.4em] text-white/50">Hotel & Resort</p>
                        </a>
                    </div>

                    {{ $slot }}
                </div>
                
                <div class="text-center mt-8 text-white/30 text-[10px] uppercase tracking-widest">
                    &copy; {{ date('Y') }} QR Food Ordering System &bull; Amanuba Resort
                </div>
            </div>
        </div>
        
        <style>
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            .pulse-animation {
                animation: pulse 2s infinite;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </body>
</html>
