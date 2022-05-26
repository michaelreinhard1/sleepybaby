<x-parent-layout>
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <div class="flex justify-between">

              <h1 class="text-3xl font-bold mb-10">
                    {{ __('Your wishlists') }}
              </h1>


                {{-- Your wishlists --}}
                <div class="flex flex-col  mb-10">
                    <x-link href="{{ route('parent.wishlist.create') }}">
                        {{ __('Create') }}
                    </x-link>

                </div>
          </div>

            {{-- display all the wishlists --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Display "no wishlists" if there are no wishlists --}}
                @if ($wishlists->isEmpty())
                <div class="p-6 bg-white border-b border-gray-200">
                    {{__('No wishlists found')}}
                </div>
                @else
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="text-left">
                                        <th class="px-4 py-2">{{__('Title')}}</th>
                                        <th class="px-4 py-2">{{__('Description')}}</th>
                                        <th class="px-4 py-2">{{__('Code')}}</th>
                                        <th class="px-4 py-2">{{__('Articles')}}</th>
                                        <th class="px-4 py-2">{{__('Share')}}</th>
                                        <th class="px-4 py-2">{{__('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlists as $wishlist)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $wishlist->name }}</td>
                                        <td class="border px-4 py-2">{{ $wishlist->description }}</td>
                                        <td class="border px-4 py-2">{{ $wishlist->code }}</td>
                                        <td class="border px-4 py-2">{{ count(json_decode($wishlist->article_id, true)) }}</td>
                                        {{-- Share invitation url --}}
                                        <td class="border px-4 py-2">
                                                <p class="flex justify-between">
                                                    {{$wishlist->share}}
                                                    <a href="{{ route('parent.wishlist.share', $wishlist->id) }}"
                                                        class="text-blue-500 hover:text-blue-700">
                                                        {{__('Share')}}
                                                    </a>
                                                </p>
                                        </td>
                                        <td class="border px-4 py-2 flex justify-between">
                                            <a href="{{ route('parent.wishlist.show', $wishlist) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                {{ __('View') }}
                                            </a>
                                            <form action="{{ route('parent.wishlist.destroy', $wishlist) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 ml-4">
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
                @endif
                {{-- if success --}}
                @if (session('success'))
                <div class="flex p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
                @endif
            </div>


        </div>
</x-parent-layout>