<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-white">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/50 focus:border-bali-orange focus:ring-bali-orange rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@amanuba.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-white">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/50 focus:border-bali-orange focus:ring-bali-orange rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-white/30 bg-white/20 text-bali-orange shadow-sm focus:ring-bali-orange" name="remember">
                <span class="ms-2 text-sm text-white/90">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white/70 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bali-orange" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="ms-4 inline-flex items-center px-6 py-3 bg-gradient-to-r from-bali-orange to-[#EA580C] border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:shadow-lg hover:shadow-bali-orange/30 active:bg-bali-orange focus:outline-none focus:ring-2 focus:ring-bali-orange focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Log in') }} <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
