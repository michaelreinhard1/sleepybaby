<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Articles')}}
        </h2>
    </x-slot>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Wishlist for')}}</h2>
          <h1 class="text-lg font-bold mt-5">{{__('Wishlist for')}} {{$wishlist[0]->name}}</h1>
          <p class="text-gray-700 text-lg mb-5">{{$wishlist[0]->description}}</p>
          <x-succes-message></x-succes-message>
          <div class="grid-layout">
            {{-- for each article --}}
            @forelse ($articles as $article)
            <div class="grid-item">
              <div class="w-full aspect-square rounded-lg flex justify-center items-center overflow-hidden sm:h-40">
                <img class="object-cover h-full" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}" class="w-full h-full object-center object-cover group-hover:opacity-75">
              </div>
                <div>
                  <h3 class="mt-4 text-sm text-gray-700">{{$article->title}}</h3>
                  <p class="text-lg  text-emerald-500 font-bold my-4">€ {{$article->price}}</p>
                  <div class="flex flex-col justify-between items-center gap-2">
                    <form action="{{ route('user.cart.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="id" value="{{ $article->id }}">
                        <button type="submit" class="flex justify-center items-center text-sm text-white bg-blue-500	 rounded-md px-4 py-2 w-full">
                            {{ __('Add') }}
                        </button>
                    </form>
                  </div>
                </div>
            </div>

            @empty
            <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full col-span-full">
              <div class="px-4 py-5 border-b border-gray-200 sm:px-6 w-full">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                      {{ __('No articles found') }}
                  </h3>
              </div>
            </div>
            @endforelse
          </div>
          @if ($articles->count() > 24)
            <div class="mx-auto py-5">
                {{ $articles->links() }}
            </div>
          @endif
        </div>
      </div>

    </x-user-layout>
