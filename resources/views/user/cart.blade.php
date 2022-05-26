<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Articles')}}
        </h2>
    </x-slot>
    <div class="bg-white h-screen">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold mb-10">{{__('Shopping cart')}}</h1>
        <hr>

        {{-- If CartItems is empty --}}
        @if (Cart::isEmpty())
            <div class="text-center">
                <h2 class="text-xl text-gray-800">{{__('Your cart is empty')}}</h2>
                <a href="{{ route('user.articles') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">{{__('Go to articles')}}</a>
            </div>
        @else
    <div class="flex flex-col">
        @foreach ($cartItems as $item)
        <div class="flex w-full justify-between max-h-40 my-5">

            <div>
                <img class="w-32" src="{{ asset('images/' . $item->attributes->image)}}" alt="">
            </div>
            <div class="w-2/4">
                <h3>{{$item->name}}</h3>
                <p>{{$item->description}}</p>
            </div>
            <div class="flex flex-col">
                <div class="flex">

                    <form action="{{ route('user.cart.remove.item', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="font-semibold border bg-gray-100 rounded px-3">
                            -
                        </button>
                    </form>
                    <p class="bg-gray-100 px-3">
                        {{$item->quantity}}
                    </p>

                    <form action="{{ route('user.cart.add.item', $item->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="{{$item->quantity}}">
                        <button type="submit" class="font-semibold bg-gray-100 rounded px-3">
                            +
                        </button>
                    </form>
                </div>
                <form action="{{ route('user.cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <button type="submit" class="text-red-500 rounded-lg">
                        {{ __('Remove') }}
                    </button>
                </form>
            </div>
            <div>
                <p>€ {{$item->price}}</p>
            </div>
        </div>
        <hr>
        @endforeach

        <div class="flex justify-between">
            <div>
                <p>{{__('Total')}}: € {{Cart::getTotal()}}</p>
            </div>
            <div>
                <form method="get" action="{{route('user.checkout')}}">
                    <input required name="name" type="text" placeholder="{{__('Name')}}">
                    <input required name="remarks" type="text" placeholder="{{__('Remarks')}}">
                    <button type="submit" class="text-green-500 rounded-lg">
                        {{ __('Checkout') }}
                    </button>
                </form>
            </div>


        </div>



    </div>
    @endif


        </div>
    </div>


</x-user-layout>
