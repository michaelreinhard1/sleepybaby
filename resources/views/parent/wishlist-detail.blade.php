<x-parent-layout>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <h1 class="text-3xl font-bold mb-10">
                {{ __('Wishlist') }} - {{ $wishlist->name }}
          </h1>
            {{-- Your wishlists --}}
            <div class="flex flex-col  mb-10">
                <x-link href="{{ route('parent.widhlist.add.articles', $wishlist) }}">
                    {{ __('Add articles') }}
                </x-link>
            </div>

            {{-- If $wishlist->article_id array is empty --}}
            @if (empty(json_decode($wishlist->article_id)))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('No articles found')}}
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('Articles')}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <table class="table-auto h-px">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">{{__('Image')}}</th>
                                        <th class="px-4 py-2">{{__('Title')}}</th>
                                        <th class="px-4 py-2">{{__('Price')}}</th>
                                        <th class="px-4 py-2">{{__('URL')}}</th>
                                        <th class="px-4 py-2">{{__('Category')}}</th>
                                        <th class="px-4 py-2">{{__('Shop')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-x-hidden overflow-y-scroll h-px">
                                    @foreach ($articles as $article)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            <img class="w-full object-cover" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}">
                                        </td>
                                        <td class="border px-4 py-2">{{ $article->title }}</td>
                                        <td class="border px-4 py-2">{{__('€')}}{{ $article->price }}</td>
                                        <td class="text-blue-400 border px-4 py-2">
                                            <a target="_blank" href="{{ $article->url }}">
                                                {{ $article->url }}
                                            </a>
                                        </td>
                                        <td class="border px-4 py-2">{{ $article->category }}</td>
                                        <td class="border px-4 py-2">{{ $article->shop }}</td>
                                        <td class="border px-4 py-2">
                                            <form action="{{ route('parent.wishlist.remove.item', $article) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                <button type="submit"
                                                    class="text-blue-500 hover:text-blue-700 ml-4">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            {{-- display all the wishlists --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- if success --}}
                @if (session('success'))
                <div class="flex p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
                @endif
            </div>


        </div>
      </div>
</x-parent-layout>