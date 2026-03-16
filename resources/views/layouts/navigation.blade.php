<nav class="bg-[#E9EFE5]">
    <div class="max-w-full mx-10">
        <div class="flex justify-between items-center h-20">

            <!-- Left : Logo -->
            <div class="flex items-center space-x-3">
                <a href="/">
                    <img src="{{ asset('storage/logo/logo.png') }}" class="h-20 w-25" alt="Go Gecko Logo">
                </a>

                <div class="leading-tight">
                    <div class="ml-10">
                        <img src="{{ asset('storage/logo/logo-text.png') }}" alt="Go Gecko" class="h-20">
                    </div>
                </div>
            </div>

            <!-- Center : Navigation -->
            <div class="hidden md:flex items-center space-x-10 text-gray-500 font-medium mr-24">
                @if (Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-green-700 transition">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="hover:text-green-700 transition">Products</a>
                    <a href="{{ route('admin.branches.index') }}" class="hover:text-green-700 transition">Branches</a>
                    <a href="{{ route('admin.orders') }}" class="hover:text-green-700 transition">Orders</a>
                    <a href="{{ route('admin.blogs.index') }}" class="hover:text-green-700 transition">Blogs</a>
                    <a href="{{ route('admin.price-requests.index') }}" class="hover:text-green-700 transition">Price Requests</a>
                    <a href="{{ route('admin.contact') }}" class="hover:text-green-700 transition">Contact</a>
                @elseif (Auth::check() && Auth::user()->isBranch())
                    <a href="{{ route('branch.dashboard') }}" class="hover:text-green-700 transition">Dashboard</a>
                    <a href="{{ route('branch.orders') }}" class="hover:text-green-700 transition">Orders</a>
                    <a href="{{ route('branch.price-requests.index') }}" class="hover:text-green-700 transition">Price Requests</a>
                @else
                    <a href="/" class="hover:text-green-700 transition">Home</a>
                    <a href="/products" class="hover:text-green-700 transition">Products</a>
                    <a href="/blogs" class="hover:text-green-700 transition">Blogs</a>
                    <a href="/contact" class="hover:text-green-700 transition">Contact Us</a>
                @endif
            </div>

            <!-- Right : Icons + Auth -->
            <div class="flex items-center space-x-6">

                <!-- Cart -->
                @php
                    if(Auth::check() && Auth::user()->isCustomer()){
                        $cartCount = \App\Models\CartItem::where('customer_id', Auth::id())->sum('quantity');
                    }else{
                        $cart = session()->get('guest_cart', []);
                        $cartCount = array_sum($cart);
                    }
                @endphp

                <a href="/cart" class="relative text-gray-700 hover:text-green-700 flex items-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>

                    <span id="cart-count" class="ml-2 text-sm text-gray-700">
                        {{ $cartCount }}
                    </span>

                </a>

                @guest
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm">Login</span>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <a href="{{ route('register') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:text-[#076807] hover:bg-[#E9EFE5] transition">
                            Register
                        </a>
                        <a href="{{ route('login') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:text-[#076807] hover:bg-[#E9EFE5] transition">
                            Login
                        </a>
                    </div>
                </div>
            @endguest

                @auth
                    <div class="flex items-center space-x-4">

                        <span class="text-sm text-gray-700">
                            {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-red-600 hover:underline">
                                Logout
                            </button>
                        </form>

                    </div>
                @endauth

                <!-- Search -->
                <button class="text-gray-700 hover:text-green-700">
                    <a href="/products#searchbar">
                        <svg @click="show = true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:cursor-pointer"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </a>
                </button>

            </div>

        </div>
    </div>
</nav>
