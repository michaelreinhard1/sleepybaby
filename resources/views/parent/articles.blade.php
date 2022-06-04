<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>

          <div class="flex justify-between flex-row items-center my-5">

          <x-succes-message></x-succes-message>


            <h1 class="text-lg font-bold">
              {{ __('Add articles to') }} {{ $wishlist->name }}
            </h1>

              <a class="bg-emerald-500 text-white p-2 rounded-lg flex items-center px-8" href="{{ route('parent.wishlist.show', $wishlist) }}">
                {{__('View')}}
              </a>

          </div>

          <form class="flex gap-3 mb-4" method="GET" class="mb-10" action="{{ route('parent.wishlist.add.articles', $wishlist) }}" >
            <div class="w-1/2">
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
                <div class="w-full aspect-square rounded-lg flex justify-center items-center overflow-hidden sm:h-40">
                  <img class="object-cover h-full" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}" class="w-full h-full object-center object-cover group-hover:opacity-75">
                </div>
                <div>
                    <h3 class="mt-4 text-sm text-gray-500">{{$article->shop}}</h3>
                    <h3 class="mt-4 text-sm text-gray-700">{{$article->title}}</h3>
                    <p class="text-lg  text-emerald-500 font-bold my-4">€ {{$article->price}}</p>
                    <div class="flex flex-col justify-between items-center gap-2">
                      <a class="flex justify-center items-center w-full bg-emerald-500 rounded-md p-2 text-white" href="{{ $article->url }}" target='_blank'>
                        {{ __('View') }}
                      </a>
                      <form action="{{ route('parent.wishlist.add.item', $article) }}" method="POST" class="w-full">
                          @csrf
                          <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                          <input class="mb-6" type="hidden" name="article" value="{{ $article->id }}">
                          <button type="submit" class="flex justify-center items-center text-sm text-white bg-blue-500	 rounded-md px-4 py-2 w-full">
                              {{ __('Add') }}
                          </button>
                      </form>
                    </div>
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
