<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('My wishlists')}}</h2>
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

            {{-- if success --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-fit mb-10">
                {{ session('success') }}
            </div>
            @endif


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
                    <div class="group h-50 flex flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60">
                        <img class="aspect-video w-full rounded-t-2xl object-cover object-center" src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                        <div class="p-4">
                          <small class="text-emerald-400 text-xs">{{$wishlist->code}}</small>
                          <small class="text-emerald-400 text-xs">{{__('Articles')}}: {{ count(json_decode($wishlist->articles, true)) }}</small>
                          <h1 class="text-2xl font-medium text-slate-600 pb-2">{{$wishlist->name}}</h1>
                          <p class="text-sm tracking-tight font-light text-slate-400 leading-6">
                            {{ substr($wishlist->description, 0, 100) }}
                            {{ strlen($wishlist->description) > 100 ? '...' : '' }}
                          </p>
                          <div class="flex">

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
                                class="text-green-500 hover:text-green-700 ">
                                {{ __('Export to') }}
                            </button>
                            </form>
                            <form action="{{ route('parent.wishlist.destroy', $wishlist) }}"
                                method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 ">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                            </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
            </div>


        </div>
    </div>
</x-parent-layout>