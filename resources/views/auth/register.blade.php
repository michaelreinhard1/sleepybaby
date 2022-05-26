<x-app-layout>
    <x-slot name="navigation">
    </x-slot>
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
                            <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{__('Register')}}</h1>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Sign in to access your account')}}</p>

                        </div>
                        <div class="m-7">

                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="email" :value="__('Name')" />
                                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                                </div>
                                <div class="mb-6">
                                    <x-label  class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="email" :value="__('Email')" />
                                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                                </div>
                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="password" :value="__('Password')" />
                                    <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                                </div>
                                <div class="mb-6">
                                    <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                                </div>
                                <div class="mb-6">
                                    <x-button>
                                        {{ __('Register') }}
                                    </x-button>
                                </div>
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <p class="text-sm text-center text-gray-400">{{__("Already registered?")}}
                                    <a href="{{ route('login') }}" class="text-emerald-400 focus:outline-none focus:underline focus:text-emerald-500 dark:focus:border-emerald-800"> {{__('Log in')}}</a></p>

                        </div>
                </div>
            </div>

        </form>
    </x-auth-card>
</x-app-layout>
