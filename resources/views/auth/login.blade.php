<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Mostrar mensaje de error para cuenta inhabilitada -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" /> <!-- Cambiar a blanco -->
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" /> <!-- Cambiar a blanco -->
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" /> <!-- Cambiar a blanco -->

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" /> <!-- Cambiar a blanco -->
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span> <!-- Cambiar a blanco -->
            </label>
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <x-primary-button class="w-full sm:w-auto text-center">
                {{ __('Log in') }}
            </x-primary-button>
            <div class="mt-2 sm:hidden text-center">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-gray-300" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="hidden sm:block mt-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white hover:text-gray-300" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
