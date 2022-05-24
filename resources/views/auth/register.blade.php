<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div> --}}


            <div class="container mx-auto">
                    <div class="max-w-md mx-auto my-10">
                        <div class="text-center">
                            <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Register</h1>
                            <p class="text-gray-500 dark:text-gray-400">Sign in to access your account</p>

                        </div>
                        <div class="m-7">

                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="email" :value="__('Name')" />
                                    <x-input id="name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="text" name="name" :value="old('name')" required autofocus />
                                </div>
                                <div class="mb-6">
                                    <x-label  class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="email" :value="__('Email')" />
                                    <x-input id="email" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="email" name="email" :value="old('email')" required />
                                </div>
                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="password" :value="__('Password')" />
                                    <x-input id="password" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="password" name="password" required autocomplete="new-password" />
                                </div>
                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-input id="password_confirmation" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-pink-100 focus:border-pink-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="password" name="password_confirmation" required />
                                </div>
                                <div class="mb-6">
                                    <button class="w-full px-3 py-4 text-white bg-pink-500 rounded-md focus:bg-pink-600 focus:outline-none">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <p class="text-sm text-center text-gray-400">{{__("Already registered?")}}
                                    <a href="{{ route('login') }}" class="text-pink-400 focus:outline-none focus:underline focus:text-pink-500 dark:focus:border-pink-800"> {{__('Log in')}}</a>.</p>

                        </div>
                </div>
            </div>

        </form>
    </x-auth-card>
</x-guest-layout>
