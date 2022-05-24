<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->


        <form method="POST" action="{{ route('login') }}" class="flex bg-white dark:bg-gray-900">
            @csrf
                <div class="container mx-auto">
                    <div class="max-w-md mx-auto my-10">
                        <div class="text-center">
                            <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Sign in</h1>
                            <p class="text-gray-500 dark:text-gray-400">Sign in to access your account</p>
                        </div>
                        <div class="m-7">

                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="email" :value="__('Email')" />
                                    <x-input id="email" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="email" name="email" :value="old('email')" required autofocus />
                                </div>
                                <div class="mb-6">
                                    <div class="flex justify-between mb-2">
                                        <x-label for="password" class="text-sm text-gray-600 dark:text-gray-400" :value="__('Password')" />
                                        @if (Route::has('password.request'))
                                        <a class="text-sm text-gray-400 focus:outline-none focus:text-pink-500 hover:text-pink-500 dark:hover:text-pink-300" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                        @endif
                                    </div>
                                    <x-input autocomplete="current-password" required type="password" name="password" id="password" placeholder="Your Password" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                                </div>
                                <div class="mb-6">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50" name="remember">
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <div class="mb-6">
                                    <button class="w-full px-3 py-4 text-white bg-pink-500 rounded-md focus:bg-pink-600 focus:outline-none">
                                        {{ __('Log in') }}
                                    </button>
                                </div>
                                <p class="text-sm text-center text-gray-400">{{__("Don't have an account yet?")}}
                                    <a href="{{ route('register') }}" class="text-pink-400 focus:outline-none focus:underline focus:text-pink-500 dark:focus:border-pink-800"> {{__('Register')}}</a>.</p>
                        </div>
                </div>
            </div>


            <!-- Email Address -->
            {{-- <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div> --}}

        </form>
    </x-auth-card>
</x-guest-layout>
