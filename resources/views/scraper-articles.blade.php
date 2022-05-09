<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Articles')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Display all the articles from the database --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Display "no ctaegories" if there are no articles --}}
                @if (count($articles) == 0)
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('No articles found')}}
                </div>
                @else
                {{-- Make a succes box and warning box--}}
                @if (session('success'))
                <div class="flex items-center justify-center p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('warning'))
                <div class="flex items-center justify-center p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                    {{ session('warning') }}
                </div>
                @endif
                
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Make a select with options category filter --}}
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{__('Filter by category')}}
                            </h3>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <select class="form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" id="category" name="category">
                                        <option value="">{{__('All categories')}}</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category}}">{{$category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                
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
                                            <img class="w-full object-cover" src="{{ asset('images/' . $article->image)}}" alt="">
                                        </td>
                                        <td class="border px-4 py-2">{{ $article->title }}</td>
                                        <td class="border px-4 py-2">{{__('€')}}{{ $article->price }}</td>
                                        <td class="text-blue-400 border px-4 py-2"><a target="_blank" href="{{ $article->url }}">{{ $article->url }}</a></td>
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

</x-app-layout>