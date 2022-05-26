<x-app-layout>
    <x-slot name="navigation">
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

    @if (Route::has('login'))
    {{-- <div class=" fixed top-0 right-0 sm:block w-full">

            <nav class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-800">
                <div class="container flex flex-wrap justify-end items-center mx-auto">
                <div class="flex md:order-2">

                    @auth
                    <a href="{{ route('dashboard') }}" class="mx-3 text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0 dark:bg-emerald-600 dark:hover:bg-emerald-500 dark:focus:ring-emerald-800">{{__('Dashboard')}}</a>

                     @else
                        <a href="{{ route('login') }}" class="mx-3 text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0 dark:bg-emerald-600 dark:hover:bg-emerald-500 dark:focus:ring-emerald-800">{{__('Log in')}}</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mx-3 text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0 dark:bg-emerald-600 dark:hover:bg-emerald-500 dark:focus:ring-emerald-800">{{__('Register')}}</a>
                    @endif
                    @endauth

                    <button data-collapse-toggle="mobile-menu-4" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-4" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                </div>
                </div>
            </nav>

    </div>
 --}}
                {{-- <div class=" fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div> --}}
    @endif
    <form method="POST" action="{{ route('invitation.enter') }}" class="flex bg-white dark:bg-gray-900">
        @csrf
            <div class="container mx-auto">
                <div class="max-w-md mx-auto my-10">
                    <div class="text-center">
                        <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{__('Invitation code')}}</h1>
                        <p class="text-gray-500 dark:text-gray-400">{{__('Enter your invitation code')}}</p>
                    </div>
                    <div class="m-7">
                            <div class="mb-6">
                                <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="code" :value="__('Invitation code')" />
                                <x-input id="code" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="code" name="code" required autofocus />
                            </div>
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="mb-6">
                                <x-button>
                                    {{ __('Enter') }}
                                </x-button>
                            </div>
                            {{-- Do you want to create your own wishlist? Login or register here --}}
                                <p class="text-sm text-center text-gray-400">{{__("Do you want to create your own wishlist?")}}
                                    <br>
                                    <a href="{{ route('register') }}" class="text-emerald-400 text-center focus:outline-none focus:underline focus:text-emerald-500 dark:focus:border-emerald-800"> {{__('Register')}}</a>
                                    or
                                    <a href="{{ route('login') }}" class="text-emerald-400 text-center focus:outline-none focus:underline focus:text-emerald-500 dark:focus:border-emerald-800"> {{__('Login')}}</a>
                                </p>
                </div>
            </div>
        </div>

    </form>
</x-auth-card>
</x-app-layout>