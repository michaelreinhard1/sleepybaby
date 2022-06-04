<x-parent-layout>
    <div class="bg-white relative h-screen">

        <x-succes-message></x-succes-message>

        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{ __('Wishlist') }} - {{ $wishlist->name }}</h2>

          <div class="flex justify-between flex-row items-center my-5">
            <h1 class="text-lg font-bold sm:text-2xl sm:mb-5">
                {{ __('Wishlist for') }} {{ $wishlist->name }}
            </h1>

                <a class="bg-emerald-500 text-white p-2 rounded-full flex items-center" href="{{ route('parent.wishlist.add.articles', $wishlist) }}">
                    <span class="material-symbols-outlined">
                      add
                      </span>
                  </a>

          </div>

            @if (empty(json_decode($wishlist->articles)) && count($wishlist->orders) == 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('No articles found')}}
                </div>
            </div>
            @else
            <div class="flex flex-col gap-4">
            @foreach ($articles as $article)
                <div class="grid grid-cols-4 shadow-md border border-slate-200 rounded-2xl p-5 gap-4 sm:w-full sm:mx-auto">
                        <div class="rounded-full overflow-hidden w-20 aspect-square">
                            <img class="w-full h-full object-contain" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}">
                        </div>
                        <div class="flex flex-col justify-between col-span-2 px-5">
                            <div>
                                <h5>
                                    {{ $article->title }}
                                </h5>
                                <p class="text-sm text-gray-400">
                                    {{ $article->shop }}
                                </p>
                            </div>
                            <h4 class="font-bold text-md text-emerald-500">
                                {{__('€')}} {{ $article->price }}
                            </h4>
                        </div>

                    <form action="{{ route('parent.wishlist.remove.item', $article) }}"
                    method="POST" class="flex flex-col justify-end sm:justify-center">
                    @csrf
                    <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                    <input type="hidden" name="article" value="{{ $article->id }}">
                    <button type="submit"
                        class="text-red-500 hover:text-red-700">
                        {{ __('Delete') }}
                    </button>
                    </form>
                </div>
                @endforeach
                @foreach ($ordered_articles as $article)
                <div class="grid grid-cols-4 shadow-md border border-slate-200 rounded-2xl p-5 gap-4 sm:w-full sm:mx-auto bg-green-100">
                    <div class="rounded-full overflow-hidden w-20 aspect-square">
                        <img class="w-full h-full object-contain" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}">
                    </div>
                    <div class="flex flex-col justify-between col-span-2 px-5">
                        <div>
                            <h5>
                                {{ $article->title }}
                            </h5>
                            <p class="text-sm text-gray-400">
                                {{ __('Ordered by') }} {{ $article->order_name }}
                            </p>
                        </div>
                        <h4 class="font-bold text-md text-emerald-500">
                            {{__('€')}} {{ $article->price }}
                        </h4>
                    </div>
            </div>
                @endforeach
            </div>
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                                                <input type="hidden" name="article" value="{{ $article->id }}">
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach ($ordered_articles as $article)
                                    <tr class="bg-green-100">
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
                                        <td class="border px-4 py-2 w-full">
                                            {{ __('Ordered by') }} {{ $article->order_name }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
            @endif
            <form action="{{ route('parent.wishlist.destroy', $wishlist) }}"
            method="POST" class=" flex-grow mt-10 flex justify-center">
            @csrf
            <button type="submit"
                class="text-white hover:text-gray-200 bg-red-500 flex justify-center items-center py-2 px-6 rounded w-max text-md mb-10">
                  {{__('Delete wishlist')}}
            </button>
            </form>
        </div>
      </div>
</x-parent-layout>