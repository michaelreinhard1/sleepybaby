<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('Welcome to the Parent Dashboard') }}
          </h1>

          {{-- Create your own wishlist --}}
          <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-bold mb-4">
                {{ __('Create your own wishlist') }}
            </h2>
            <a href="{{ route('parent.wishlists.show') }}" class="text-blue-500 hover:text-blue-700">
                {{ __('Create') }}
            </a>
          </div>
        </div>
      </div>

      {{-- <div class="max-w-2xl  mx-auto py-5">
          {{ $articles->links() }}
      </div> --}}

</x-parent-layout>
