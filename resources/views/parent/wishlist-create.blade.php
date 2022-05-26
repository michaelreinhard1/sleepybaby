<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('New wishlist') }}
          </h1>
            <div class="flex flex-col  mb-10">
                <form method="POST" action="{{ route('parent.wishlist.store') }}">
                    @csrf
                    <div class="flex flex-col mb-6">
                        <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="name" :value="__('Name')" />
                        <x-input id="name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="name" name="name" required autofocus />

                    </div>
                    <div class="flex flex-col mb-6">
                        <x-label class="block mb-2 text-sm text-gray-600 dark:text-gray-400" for="description" :value="__('Description')" />
                        <textarea id="description" type="text" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>

                    </div>
                    {{-- Button --}}
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Create') }}
                        </button>
                    </div>
                </form>
                {{-- If success --}}
                @if (session('success'))
                <div class="flex items-center justify-center p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
                @endif
            </div>


        </div>
      </div>
</x-parent-layout>