<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Articles')}}
        </h2>
    </x-slot>
    <x-slot name="navigation">
    </x-slot>

    <div class="py-12 w-full">
        <div class=" mx-auto sm:px-6 lg:px-8">
            {{-- Display all the articles from the database --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                {{-- Display "no ctaegories" if there are no articles --}}
                {{-- Make a succes box and warning box--}}
                <x-succes-message></x-succes-message>

                @if (session('warning'))
                <div class="flex items-center justify-center p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                    {{ session('warning') }}
                </div>
                @endif

                <div class="p-6 bg-white border-b border-gray-200 w-full">
                    {{-- Make a select with options category filter --}}
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                                <form class="flex gap-3 mb-4" method="GET" class="mb-10" action="{{ route('admin.scraped.articles') }}" >
                                    <div class="w-1/2">
                                      <select onchange="this.form.submit()" name="category" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 mb-5">
                                        <option value="">
                                          {{ __('All categories') }}
                                        </option>
                                        @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}" {{ $key == request()->query('category') ? 'selected' : '' }}>
                                          {{ $category }}
                                        </option>
                                        @endforeach
                                      </select>
                                      <select onchange="this.form.submit()" name="shop" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                                        <option value="">
                                          {{ __('All shops') }}
                                        </option>
                                        @foreach ($shops as $shop)
                                        <option value="{{ $shop }}" {{ $shop == request()->query('shop') ? 'selected' : '' }}>
                                          {{ $shop }}
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
                        </div>
                    </div>

                    @if (count($articles) == 0)
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{__('No articles found')}}
                    </div>
                    @else
                    <div class="flex flex-wrap -mx-3 mb-6 w-full">
                        <div class=" px-3 w-full">
                            <table class="table-auto h-px w-full">
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
                                <tbody class=" overflow-y-scroll h-px">
                                    @foreach ($articles as $article)
                                    <tr>
                                        <td class=" overflow-hidden w-20 aspect-square border">
                                            <img class="w-full h-full object-contain" src="{{ asset('images/' . $article->image)}}" alt="{{$article->title}}">
                                        </td>
                                        <td class="border px-4 py-2">{{ $article->title }}</td>
                                        <td class="border px-4 py-2">{{__('€')}}{{ $article->price }}</td>
                                        <td class="text-blue-400 border px-4 py-2 text-center"><a target="_blank" href="{{ $article->url }}">{{__('View article')}}</a></td>
                                        <td class="border px-4 py-2">{{ $article->category }}</td>
                                        <td class="border px-4 py-2">{{ $article->shop }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if ($articles->count() > 0)
      <div class="mx-auto py-5">
          {{ $articles->links() }}
      </div>
    @endif
</x-admin-layout>