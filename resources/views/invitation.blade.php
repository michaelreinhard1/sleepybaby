<x-app-layout>
    <x-slot name="navigation">
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-48 fill-current text-gray-500" />
            </a>
        </x-slot>

    <form method="POST" action="{{ route('invitation.enter') }}" class="flex bg-white ">
        @csrf
            <div class="container mx-auto">
                <div class="max-w-md mx-auto my-10">
                    <div class="text-center">
                        <h1 class="my-3 text-3xl font-semibold text-gray-700 ">{{__('Invitation code')}}</h1>
                        <p class="text-gray-500 ">{{__('Enter your invitation code')}}</p>
                    </div>
                    <div class="m-7">
                            <div class="mb-6">
                                <x-label class="block mb-2 text-sm text-gray-600 " for="code" :value="__('Invitation code')" />
                                <x-input id="code" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300  " type="code" name="code" required autofocus />
                            </div>
                            <x-succes-message></x-succes-message>

                            @if (session('error'))
                            <div class="flex items-center justify-center p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                                {{ session('error') }}
                            </div>
                            @endif
                            <div class="mb-6 mt-6">
                                <x-button>
                                    {{ __('Enter') }}
                                </x-button>
                            </div>
                            <p class="text-sm text-center text-gray-400">{{__("Do you want to create your own wishlist?")}}
                                <br>
                                <a href="{{ route('register') }}" class="text-emerald-400 text-center focus:outline-none focus:underline focus:text-emerald-500 "> {{__('Register')}}</a>
                                {{__('or')}}
                                <a href="{{ route('login') }}" class="text-emerald-400 text-center focus:outline-none focus:underline focus:text-emerald-500 "> {{__('Login')}}</a>
                            </p>
                </div>
            </div>
        </div>

    </form>
</x-auth-card>
</x-app-layout>