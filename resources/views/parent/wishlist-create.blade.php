<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('Create your wishlist') }}
          </h1>


            {{-- Your wishlists --}}
            <div class="flex flex-col  mb-10">
                <h2 class="text-2xl font-bold mb-4">
                    {{ __('New wishlist') }}
                </h2>

                {{-- A form to create a new wishlist --}}
                <form method="POST" action="{{ route('parent.wishlist.store') }}">
                    @csrf
                    <div class="flex flex-col">
                        <label for="name" class="text-sm font-semibold text-gray-600">
                            {{ __('Name') }}
                        </label>
                        <input id="name" type="text" class="form-input mt-1 block w-full" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="flex flex-col">
                        <label for="description" class="text-sm font-semibold text-gray-600">
                            {{ __('Description') }}
                        </label>
                        <textarea id="description" type="text" class="form-input mt-1 block w-full" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                    </div>
                    {{-- Button --}}
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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