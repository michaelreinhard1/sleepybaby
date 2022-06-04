<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Payment successfully completed')}}
        </h2>
    </x-slot>
    <div class="bg-white h-screen">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8 flex flex-col items-center justify-center">
        <h1 class="text-lg font-bold mt-5 ">
            {{__('Payment successfully completed')}}
        </h1>
        <span class="material-symbols-outlined text-emerald-500 my-5">
            task_alt
        </span>

        <a href="{{ route('user.articles') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded transition-all text-sm">
                {{__('Go to articles')}}
        </a>

        </div>
    </div>
</x-user-layout>
