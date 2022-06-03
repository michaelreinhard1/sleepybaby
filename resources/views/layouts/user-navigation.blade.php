<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('user.articles') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('user.articles')" :active="request()->routeIs('user.articles')">
                        {{ __('Articles') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('user.cart.show')" :active="request()->routeIs('user.cart.show')">
                        {{ __('Cart') }}
                    </x-nav-link>
                </div>

                @if (Auth::check() && Auth::user()->isAdmin)
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.scraper')" :active="request()->routeIs('admin.scraper')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endif

            </div>

            @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:flex">

                @auth
                @else
                    <a href="{{ route('invitation.show') }}" class=" text-emerald-500 block px-3 py-2 underline rounded-md text-base font-medium">{{__('Wrong code?')}}</a>
                    <a href="{{ route('login') }}" class="ml-4 bg-emerald-500 text-white block px-3 py-2 rounded-md text-base font-medium">{{__('Log in')}}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 bg-emerald-500 text-white block px-3 py-2 rounded-md text-base font-medium">{{__('Register')}}</a>
                    @endif
                @endauth
            </div>
            @endif


            <!-- Settings Dropdown -->
            @if (Route::has('login'))
                @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth
            @endif


            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class=" space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-responsive-nav-link :href="route('user.articles')" :active="request()->routeIs('user.articles')">
                {{ __('Articles') }}
            </x-responsive-nav-link>
        </div>
        <div class=" space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-responsive-nav-link :href="route('user.cart.show')" :active="request()->routeIs('user.cart.show')">
                {{ __('Cart') }}
            </x-responsive-nav-link>
        </div>

        @if (Auth::check() && Auth::user()->isAdmin)
        <div class=" space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-responsive-nav-link :href="route('admin.scraper')" :active="request()->routeIs('admin.scraper')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @endif

        <!-- Responsive Settings Options -->
        @if (Route::has('login'))
        @auth

        <div class="pt-4 pb-1 border-t border-gray-200">
            @if (Auth::check() && Auth::user()->isAdmin)
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            @endif

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">
                        {{ __('Log In') }}
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mt-1 block px-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">
                            {{ __('Register') }}
                        </a>
                    @endif
                </div>
            </div>
        @endauth
        @endif
    </div>
</nav>
