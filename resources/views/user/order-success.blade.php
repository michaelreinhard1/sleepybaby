<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Payment successfully completed')}}
        </h2>
    </x-slot>
    <div class="bg-white h-screen">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold mb-10">{{__('Payment successfully completed')}}</h1>

        <a href="{{ route('user.articles') }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{__('Go to articles')}}
            </button>
        </a>

        </div>
    </div>


</x-user-layout>
