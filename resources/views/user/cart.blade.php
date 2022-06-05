<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Articles')}}
        </h2>
    </x-slot>
    <div class="bg-white h-screen">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        {{-- If CartItems is empty --}}
        @if (Cart::isEmpty())
        <div class="text-center">
            <h2 class="text-lg text-gray-800 my-5 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-gray-800">
                    shopping_cart
                </span>
                {{__('Your cart is empty')}}
            </h2>
            <a href="{{ route('user.articles') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded transition-all text-sm">
                {{__('Go to articles')}}
        </a>
        </div>
        @else
        <h1 class="text-lg font-bold my-5">{{__('Shopping cart')}}</h1>
        <div class="flex flex-col gap-4">
        @foreach ($cartItems as $item)
            <div class="grid grid-cols-4 shadow-md border border-slate-200 rounded-2xl p-5 gap-4 sm:w-full sm:mx-auto">
                <div class="rounded-full overflow-hidden w-20 aspect-square">
                    <img class="w-full h-full object-contain" src="{{ asset('images/' . $item->attributes->image)}}" alt="{{$item->name}}">
                </div>
                <div class="flex flex-col justify-between col-span-2 px-5">
                    <div>
                        <h5>
                            {{ $item->name }}
                        </h5>
                        <p class="text-sm text-gray-400">
                            {{ $item->description }}
                        </p>
                        <p class="text-sm text-gray-400">
                            {{ $item->quantity }}
                        </p>
                    </div>
                    <h4 class="font-bold text-md text-emerald-500">
                        {{__('€')}} {{ $item->price }}
                    </h4>
                </div>

            <form action="{{ route('user.cart.remove') }}" method="POST" class="flex flex-col justify-end sm:justify-center">
            @csrf
            <input type="hidden" name="id" value="{{ $item->id }}">
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                {{ __('Remove') }}
            </button>

            </form>
        </div>

        @endforeach
        <hr class="mt-5">
        <div class="flex flex-col justify-between mt-5">
            <div>
                <p class="font-bold text-emerald-500 text-lg">{{__('Total')}}: € {{Cart::getTotal()}}</p>
            </div>
            <div class="my-5 w-full">
                <form class="flex flex-col gap-3" method="get" action="{{route('user.checkout')}}">
                    <x-input  type="text" name="name" required autofocus placeholder="{{__('Name')}}" />
                    <x-input  type="text" name="email" required autofocus placeholder="{{__('Email')}}" />
                    <textarea required autofocus name="remarks" class="w-full px-3 py-2  border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-100 focus:border-emerald-300" rows="4" cols="50" placeholder={{__('Remarks')}}></textarea>
                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <p class="text-red-500 text-sm">{{ $error }}</p>
                        @endforeach
                    @endif
                    <button type="submit" class="text-white hover:text-gray-200 bg-emerald-500 flex justify-center items-center py-2 px-6 rounded-lg flex-grow">
                        <span class="material-symbols-outlined">
                            shopping_cart_checkout
                        </span>
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
