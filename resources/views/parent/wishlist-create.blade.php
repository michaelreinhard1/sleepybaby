<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('New wishlist') }}
          </h1>
          {{-- if errors --}}
            @if ($errors->any())
            {{-- for each error --}}
            @foreach ($errors->all() as $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-fit mb-10" role="alert">
                <strong class="font-bold">{{__('Whoops!')}}</strong>
                <span class="block sm:inline">{{$error}}</span>
            </div>
            @endforeach
            @endif
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-fit mb-10">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex flex-col  mb-10">
                <form method="POST" action="{{ route('parent.wishlist.store') }}">
                    @csrf
                    <div class="flex flex-col mb-6">
                        <x-label class="block mb-2 text-sm text-gray-600 " for="name" :value="__('Name')" />
                        <x-input id="name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300" type="name" name="name" required autofocus />

                    </div>
                    <div class="flex flex-col mb-6">
                        <x-label class="block mb-2 text-sm text-gray-600 " for="description" :value="__('Description')" />
                        <textarea id="description" type="text" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>

                    </div>
                    {{-- Button --}}
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Create') }}
                        </button>
                    </div>
                </form>
                {{-- If success --}}
            </div>


        </div>
      </div>
</x-parent-layout>