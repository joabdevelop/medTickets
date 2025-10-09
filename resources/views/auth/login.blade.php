<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class=" px-5 py-4">

        <form method="POST" action="{{ route('login') }}" class="">
            @csrf

            <!-- Email Address -->
            <div class="py-8 px-10">
                <x-input-label for="email" :value="__('Email')" class="text-black" />
                <x-text-input id="email" class="block mt-1 w-full border-b-1 border-l-0 rounded-none border-black/0 bg-white/0 focus-visible:outline-3 focus-visible:outline-transparent" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-black" />

                <x-text-input id="password" class="block mt-1 w-full border-b-1 border-l-0 rounded-none border-black/0 bg-white/0 focus-visible:outline-3 focus-visible:outline-transparent"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 ">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class=" border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-300">{{ __('Lembrar-me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4  ">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-black hover:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>