<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Scraper')}}
        </h2>
    </x-slot>
    <x-slot name="navigation">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.scraper.categories') }}">
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-state">
                                    {{ __('Shop') }}
                                </label>
                                {{-- A select with the shops in the option --}}
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="grid-state" name="shop">
                                        <option value="" disabled>{{ __('Select a shop') }}</option>
                                        @foreach ($shops as $key => $shop)
                                        <option value="{{ $key }}">{{ $shop }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-state">
                                    {{ __('URL') }}
                                </label>
                                <input required
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state" type="text" name="url" placeholder="https://www.example.com">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{__('Scrape categories')}}
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- Display success box --}}
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-fit mb-10">
                        {{ session('success') }}
                    </div>
                    @endif
                            {{-- Display error box --}}
                    @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
            {{-- Display all the categories from the database --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Display "no ctaegories" if there are no categories --}}
                @if (count($categories) == 0)
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('No categories found')}}
                </div>
                @else
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('Categories')}}
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">{{__('Shop')}}</th>
                                        <th class="px-4 py-2">{{__('Title')}}</th>
                                        <th class="px-4 py-2">{{__('URL')}}</th>
                                        <th>


                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $category->shop }}</td>
                                        <td class="border px-4 py-2">{{ $category->title }}</td>
                                        <td class="text-blue-400 border px-4 py-2"><a target="_blank"
                                                href="{{ $category->url }}">{{ $category->url }}</a></td>
                                        <td class="border px-4 py-2">
                                            {{-- Make a form to scrape all the articles from the category --}}
                                            <form method="POST" action="{{ route('admin.scraper.articles') }}">
                                                @csrf
                                                <input type="hidden" name="url" value="{{ $category->url }}">
                                                <input type="hidden" name="id" value="{{ $category->id }}">
                                                <input type="hidden" name="shop" value="{{ $category->shop }}">
                                                <button type="submit"
                                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    {{__('Scrape all articles')}}
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
                @endif
            </div>
        </div>
    </div>
    @if ($categories->count() > 0)
      <div class="max-w-2xl  mx-auto py-5">
          {{ $categories->links() }}
      </div>
    @endif

</x-admin-layout>
