<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('Add articles to') }} {{ $wishlist->name }}
          </h1>

          {{-- If success --}}
          @if (session()->has('success'))
          <div class="mt-4 text-sm text-green-600">
              {{ session()->get('success') }}
          </div>
          @endif


          <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">

            {{-- for each article --}}
            @foreach ($articles as $article)
            <div class="group h-50 flex flex-col justify-between shadow-md rounded-lg p-10">
                <div class="w-full aspect-square flex justify-center rounded-lg xl:aspect-w-7 xl:aspect-h-8">
                  <img class="object-cover h-full" src="{{ asset('images/' . $article->image)}}" alt="Tall slender porcelain bottle with natural clay textured body and cork stopper." class="w-full h-full object-center object-cover group-hover:opacity-75">
                </div>
                <div>
                    <h3 class="mt-4 text-sm text-gray-700">{{$article->title}}</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">€ {{$article->price}}</p>
                    <form action="{{ route('parent.wishlist.add.item', $article) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                        <input type="hidden" name="article" value="{{ $article->id }}">
                        <button type="submit" class="flex items-center mt-4 text-sm text-white bg-gray-800 rounded-lg px-4 py-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3z"></path></svg>
                            {{ __('Add to wishlist') }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="max-w-2xl  mx-auto py-5">
          {{ $articles->links() }}
      </div>


    </x-parent-layout>
