<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>

          <div class="flex justify-between flex-col sm:flex-row">

          <x-succes-message></x-succes-message>


            <h1 class="text-3xl font-bold mb-5 mt-5 sm:mb-10 sm:mt-0 ">
              {{ __('Add articles to') }} {{ $wishlist->name }}
            </h1>

              <div class="flex flex-col mb-10">
                  <x-link href="{{ route('parent.wishlist.show', $wishlist) }}">
                      {{ __('View wishlist') }}
                  </x-link>
              </div>
          </div>

          <form class="flex gap-3 mb-4" method="GET" class="mb-10" action="{{ route('parent.wishlist.add.articles', $wishlist) }}" >
            <div class="w-1/2">
              <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                {{ __('Select category') }}
              </label>
              <select onchange="this.form.submit()" name="category" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                <option value="">
                  {{ __('All categories') }}
                </option>
                @foreach ($categories as $key => $category)
                <option value="{{ $key }}" {{ $key == request()->query('category') ? 'selected' : '' }}>
                  {{ $category }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="w-1/2">
              <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-bold">
                {{ __('Price') }} 0 - {{request()->query('price')}}
              </label>
              <input onchange="this.form.submit()" name="price" id="price"
              type="range"
              class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer "
              min="0"
              max="1000"
              value="{{ request()->query('price') ?? 0 }}"
              step="10"
              />
            </div>

          </form>

          <div class="grid-layout">
            @forelse ($articles as $article)
            <div class="grid-item" id="#article{{$article->id}}">
                <div class="w-full aspect-square rounded-lg flex justify-center items-center">
                  <img class="object-cover  w-full" src="{{ asset('images/' . $article->image)}}" alt="Tall slender porcelain bottle with natural clay textured body and cork stopper." class="w-full h-full object-center object-cover group-hover:opacity-75">
                </div>
                <div>
                    <h3 class="mt-4 text-sm text-gray-700">{{__('Shop')}}: {{$article->shop}}</h3>
                    <h3 class="mt-4 text-sm text-gray-700">{{$article->title}}</h3>
                    <p class="mt-1 mb-10 text-lg font-medium text-gray-900">€ {{$article->price}}</p>
                    <x-link class="mb-6" href="{{ $article->url }}" target='_blank'>
                      {{ __('View article') }}
                    </x-link>

                    <form action="{{ route('parent.wishlist.add.item', $article) }}" method="POST">
                        @csrf
                        <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                        <input class="mb-6" type="hidden" name="article" value="{{ $article->id }}">
                        <button type="submit" class="flex items-center mt-4 text-sm text-white bg-gray-800 rounded-lg px-4 py-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3z"></path></svg>
                            {{ __('Add to wishlist') }}
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
              <div class="px-4 py-5 border-b border-gray-200 sm:px-6 w-full">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                      {{ __('No articles found') }}
                  </h3>
              </div>
          </div>
        @endforelse
          </div>
          @if ($articles->count() > 0)
          <div class="mx-auto py-5 mt-6">
              {{ $articles->links() }}
          </div>
          @endif
        </div>
      </div>



    </x-parent-layout>
