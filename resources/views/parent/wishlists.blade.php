<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('My wishlists')}}</h2>
          <div class="flex justify-between flex-col sm:flex-row">
              <h1 class="text-3xl font-bold mb-5 mt-5 sm:mb-10 sm:mt-0">
                    {{ __('My wishlists') }}
              </h1>
                <div class="flex flex-col  mb-10">
                    <x-link href="{{ route('parent.wishlist.create') }}">
                        {{ __('Create') }}
                    </x-link>

                </div>
          </div>
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-fit mb-10">
                {{ session('success') }}
            </div>
            @endif

            <div>
                <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @forelse ($wishlists as $wishlist)
                    <div class="mx-auto sm:mx-0 group h-50 flex flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60 w-max">
                        <div class="p-4 w-full">
                          <h1 class="text-2xl font-medium text-slate-600 pb-2">{{$wishlist->name}}</h1>
                          <p class="text-sm tracking-tight font-light text-slate-400 leading-6">
                            {{ substr($wishlist->description, 0, 100) }}
                            {{ strlen($wishlist->description) > 100 ? '...' : '' }}
                          </p>
                          <h2 class="text-blue-400 text-lg pb-2 font-bold">{{__('Code')}}: {{$wishlist->code}}</h2>
                          <h2 class="text-blue-400 text-lg pb-2 font-bold">{{__('Articles')}}: {{ count(json_decode($wishlist->articles, true)) }}</h2>
                          <p>
                            {{$wishlist->share}}
                          </p>
                          <div class="flex flex-col gap-2">
                            <div class="flex w-full mt-5 gap-2">
                              <a href="{{ route('parent.wishlist.show', $wishlist) }}"
                              class="flex gap-2 text-white hover:text-gray-200 bg-blue-500  justify-center items-center py-2 px-6 rounded flex-grow">
                              <span class="material-symbols-outlined">
                                  visibility
                              </span>
                              {{__('View')}}
                              </a>
                            </div>
                              <div class="grid grid-flow-row auto-rows-max grid-cols-2 w-full gap-2">
                                  <form action="{{ route('parent.wishlist.export', $wishlist) }}"
                                  method="GET" class="inline grid-">
                                  {{-- @csrf --}}
                                  <button type="submit"
                                      class="gap-2 text-white hover:text-gray-200 bg-emerald-500 flex justify-center items-center py-2 px-6 rounded w-full">
                                      <span class="material-symbols-outlined hover:text-gray-200">
                                          file_download
                                      </span>
                                      {{__('Export')}}
                                  </button>
                                  </form>

                                  <div class="w-full flex justify-center items-center">
                                          <button
                                          class="text-white hover:text-gray-200 w-full bg-blue-500 flex justify-center items-center py-2 px-6 rounded transition-all gap-2 btn" data-clipboard-text="{{$wishlist->share}}">
                                          <span class="material-symbols-outlined">
                                            content_copy
                                            </span>
                                            {{__('Copy link')}}
                                          </button>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                      @empty
                      <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('No wishlists yet') }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                {{ __('You have no wishlists yet') }}
                            </p>
                        </div>
                    </div>
                    @endforelse
                  </div>
            </div>


        </div>
    </div>
</x-parent-layout>