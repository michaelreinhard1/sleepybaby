<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('My wishlists')}}</h2>
          <div class="flex justify-between flex-row items-center my-5">
              <h1 class="text-lg font-bold sm:text-2xl">
                    {{ __('My wishlists') }}
              </h1>
                    <a class="bg-emerald-500 text-white p-2 rounded-full flex items-center" href="{{ route('parent.wishlist.create') }}">
                      <span class="material-symbols-outlined">
                        add
                        </span>
                    </a>

          </div>
          <x-succes-message></x-succes-message>

                <div class="grid-layout">
                    @forelse ($wishlists as $wishlist)
                    <div class="flex p-4 border-slate-200 border flex-col justify-center bg-white rounded-2xl shadow-md shadow-slate-300/60 col-span-full	w-full mx-auto sm:col-span-1">
                          <h1 class="text-2xl font-medium text-slate-600 pb-2 	">{{$wishlist->name}}</h1>
                          <p class="text-sm tracking-tight font-light text-slate-400 leading-6">
                            {{ substr($wishlist->description, 0, 100) }}
                            {{ strlen($wishlist->description) > 100 ? '...' : '' }}
                          </p>
                          <h2 class=" text-lg pb-2 font-bold">{{__('Code')}}: {{$wishlist->code}}</h2>
                          <h2 class=" text-lg pb-2 font-bold">{{__('Articles')}}: {{ count(json_decode($wishlist->articles, true)) }}</h2>
                          <a href="{{$wishlist->share}}" target="_blank" class="underline text-blue-400">
                            {{ substr($wishlist->share, strpos($wishlist->share, '//') + 2) }}
                          </a>
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
                                      {{__('Download')}}
                                  </button>
                                  </form>

                                  <div class="w-full flex justify-center items-center">
                                          <button
                                          class="text-white hover:text-gray-200 w-full bg-blue-500 flex justify-center items-center py-2 px-6 rounded transition-all gap-2 btn" data-clipboard-text="{{$wishlist->share}}">
                                          <span class="material-symbols-outlined">
                                            content_copy
                                            </span>
                                            {{__('Copy')}}
                                          </button>
                                  </div>
                              </div>
                            </div>
                        </div>
                      @empty
                      <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full col-span-full">
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
</x-parent-layout>