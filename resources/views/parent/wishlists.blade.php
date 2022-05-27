<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Articles')}}</h2>
          <div class="flex justify-between">

              <h1 class="text-3xl font-bold mb-10">
                    {{ __('My wishlists') }}
              </h1>


                <div class="flex flex-col  mb-10">
                    <x-link href="{{ route('parent.wishlist.create') }}">
                        {{ __('Create') }}
                    </x-link>

                </div>
          </div>

            <div>
                @if ($wishlists->isEmpty())
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ __('No wishlists yet') }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                            {{ __('You have no wishlists yet') }}
                        </p>
                    </div>
                </div>
                @else
                <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach ($wishlists as $wishlist)
                    <div class="group h-50 flex flex-col justify-between shadow-md rounded-lg p-10">
                      <div>
                          <h1 class="mt-4 text-2xl text-gray-700">{{$wishlist->name}}</h1>
                            <h3 class="mt-4 text-sm text-gray-700">{{$wishlist->description}}</h3>
                            <h3 class="mt-4 text-sm text-gray-700">
                                {{__('Code')}}: {{$wishlist->code}}
                            </h3>
                            <h3 class="mt-4 text-sm text-gray-700">{{__('Articles')}}: {{ count(json_decode($wishlist->articles, true)) }}</h3>

                            <a href="{{$wishlist->share}}"
                                class="text-blue-500 hover:text-blue-700">
                                {{__('Share')}}
                            </a>
                            <a href="{{ route('parent.wishlist.show', $wishlist) }}"
                            class="text-blue-500 hover:text-blue-700">
                            {{ __('View') }}
                            </a>
                            <form action="{{ route('parent.wishlist.export', $wishlist) }}"
                            method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-green-500 hover:text-green-700 ml-4">
                                {{ __('Export to') }}
                            </button>
                        </form>
                        <form action="{{ route('parent.wishlist.destroy', $wishlist) }}"
                            method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 ml-4">
                                {{ __('Delete') }}
                            </button>
                        </form>

                        </div>
                    </div>
                    @endforeach
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
    </div>
</x-parent-layout>