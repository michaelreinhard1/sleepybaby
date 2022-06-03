<x-parent-layout>
    <div class="bg-white h-screen">
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <h2 class="sr-only">{{__('Orders')}}</h2>
          <h1 class="text-3xl font-bold mb-5 mt-5 sm:mt-0 sm:mb-10">
                {{ __('Orders') }}
          </h1>



          @forelse ($orders_by_code as $code => $orders)

          <h2 class="text-2xl my-2 sm:my-10">
              {{ __('Orders for') }} {{ $code }}
          </h2>

          <div class="grid-layout">
            @forelse ($orders as $order)
            <div class="grid-item">
              <div>
                  <h1 class="mt-4 text-2xl text-gray-700">{{$order->name}}</h1>
                    <h3 class="mt-4 text-sm text-gray-700">{{$order->remarks}}</h3>
                    <p class="my-5 text-lg font-medium text-gray-900">€ {{$order->total}}</p>
                    <x-link class="mb-6" href="{{ route('parent.order.show', $order) }}">
                      {{ __('View order') }}
                  </x-link>
                </div>
            </div>
            @empty
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('No orders yet for') }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                        {{ __('You have no orders yet') }}
                    </p>
                </div>
            @endforelse
          </div>

          @empty
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
              <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                      {{ __('No orders yet') }}
                  </h3>
                  <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                      {{ __('You have no orders yet') }}
                  </p>
              </div>

          @endforelse
        </div>
      </div>

      {{-- If orders --}}
      {{-- @if (count($orders_by_code) > 0)
      <div class="max-w-2xl  mx-auto py-5">
          {{ $orders_by_code->links() }}
      </div>
      @endif --}}

    </x-parent-layout>
