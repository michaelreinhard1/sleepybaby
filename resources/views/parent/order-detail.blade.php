<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Order from')}} {{$order->name}}</h2>
          <h1 class="text-3xl font-bold mb-3">
            {{__('Order from')}} {{$order->name}}
          </h1>

          <h2 class="text-2xl font-bold mb-10">
           {{__('Total')}}: € {{$order->total}}
          </h2>

          <h2 class="text-2xl font-bold">
           {{__('Remarks')}}
          </h2>

          <h3 class="mb-10 mt-4 text-xl">
            {{$order->remarks}}
          </h3>

          {{-- If success --}}
          @if (session()->has('success'))
          <div class="mt-4 text-sm text-green-600">
              {{ session()->get('success') }}
          </div>
          @endif
          <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">

          @foreach ($articles as $article)
          <div class="group h-50 flex flex-col justify-between shadow-md rounded-lg p-10">
              <div class="w-full aspect-square flex justify-center rounded-lg xl:aspect-w-7 xl:aspect-h-8">
                <img class="object-fit w-full" src="{{ asset('images/' . $article->image)}}" alt="Tall slender porcelain bottle with natural clay textured body and cork stopper." class="w-full h-full object-center object-cover group-hover:opacity-75">
              </div>
              <div>
                <h3 class="mt-4 text-sm text-gray-700">{{__('Shop')}}: {{$article->shop}}</h3>
                  <h3 class="mt-4 text-sm text-gray-700">{{$article->title}}</h3>
                  <p class="my-5 text-lg font-medium text-gray-900">€ {{$article->price}}</p>
                    <x-link class="mb-6" href="{{ $article->url }}" target='_blank'>
                        {{ __('View article') }}
                    </x-link>
              </div>
          </div>
          @endforeach
        </div>
        </div>
        </div>
      </div>

      @if ($articles->count() > 24)
      <div class="max-w-2xl  mx-auto py-5">
          {{ $articles->links() }}
      </div>
      @endif

    </x-parent-layout>
