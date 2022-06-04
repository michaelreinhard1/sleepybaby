<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Order from')}} {{$order->name}}</h2>
          <h1 class="text-lg font-bold my-5 sm:text-2xl">
            {{__('Order from')}} {{$order->name}}
          </h1>

          <h2 class="text-2xl font-bold my-5 sm:text-2xl">
           {{__('Message')}}
          </h2>

          <h3 class="mt-4 text-md mb-5 ">
            {{$order->remarks}}
          </h3>

          {{-- If success --}}
          @if (session()->has('success'))
          <div class="mt-4 text-sm text-green-600">
              {{ session()->get('success') }}
          </div>
          @endif

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
          <div class="flex flex-col justify-end sm:justify-center">
            <a class="text-blue-500 text-center" href="{{ $article->url }}" target='_blank'>
              {{ __('View') }}
            </a>
          </div>
          </div>
          @endforeach
        </div>
        <hr class="my-5">

        <p class="font-bold text-emerald-500 text-lg">
          {{__('Total')}}: € {{$order->total}}
        </p>

        </div>
        </div>
      </div>

      @if ($articles->count() > 24)
      <div class="max-w-2xl  mx-auto py-5">
          {{ $articles->links() }}
      </div>
      @endif

    </x-parent-layout>
