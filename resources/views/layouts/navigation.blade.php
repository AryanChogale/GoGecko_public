<nav class="bg-[#E9EFE5]" x-data="{ mobileOpen: false }">
    <div class="max-w-full mx-4 md:mx-10">
        <div class="flex justify-between items-center h-16 md:h-20">

            <!-- Left : Logo -->
            <div class="flex items-center space-x-2">
                <a href="/">
                    <img src="https://www.gogecko.in/images/logo.png" class="h-14 md:h-20 w-auto" alt="Go Gecko Logo">
                </a>
                <div class="flex items-center">
                    <img
                        src="{{ asset('storage/logo/logo-text.png') }}"
                        alt="Go Gecko"
                        class="hidden sm:block h-10 md:h-14 ml-2 md:ml-10 w-auto object-contain"
                    />
                </div>
            </div>

            <!-- Center : Navigation (desktop) -->
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
                    <a href="{{ route('branch.products.index') }}" class="hover:text-green-700 transition">Products</a>
                    <a href="{{ route('branch.orders') }}" class="hover:text-green-700 transition">Orders</a>
                    <a href="{{ route('branch.price-requests.index') }}" class="hover:text-green-700 transition">Price Requests</a>
                @else
                    <a href="/" class="hover:text-green-700 transition">Home</a>
                    <a href="/products" class="hover:text-green-700 transition">Products</a>
                    <a href="/blogs" class="hover:text-green-700 transition">Blogs</a>
                    @auth
                        @if(Auth::user()->isCustomer())
                            <a href="{{ route('customer.orders') }}" class="hover:text-green-700 transition">Orders</a>
                        @endif
                    @endauth
                    <a href="/contact" class="hover:text-green-700 transition">Contact Us</a>
                @endif
            </div>

            <!-- Right : Icons + Auth -->
            <div class="flex items-center space-x-4">

                <!-- Cart -->
                @if (!Auth::check() || Auth::user()->isCustomer())
                    @php
                        if(Auth::check() && Auth::user()->isCustomer()){
                            $cartCount = \App\Models\CartItem::where('customer_id', Auth::id())->sum('quantity');
                        }else{
                            $cart = session()->get('guest_cart', []);
                            $cartCount = array_sum($cart);
                        }
                    @endphp
                    <a href="/cart" class="relative text-gray-700 hover:text-green-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-1 text-sm text-gray-700" data-cart-count>{{ $cartCount }}</span>
                    </a>
                @endif

                <!-- Search -->
                @if (!Auth::check() || Auth::user()->isCustomer())
                    <a href="/products#searchbar" class="text-gray-700 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </a>
                @elseif (Auth::check() && Auth::user()->isAdmin())
                    <a href="/admin/products#searchbar" class="text-gray-700 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </a>
                @elseif (Auth::check() && Auth::user()->isBranch())
                    <a href="{{ route('branch.products.index') }}#searchbar" class="text-gray-700 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </a>
                @endif

                <!-- Auth -->
                @guest
                    <div class="relative hidden md:block" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm">Login</span>
                        </button>
                        <div x-show="open"
                             x-transition
                             @click.outside="open = false"
                             class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:text-[#076807] hover:bg-[#E9EFE5] transition">Register</a>
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:text-[#076807] hover:bg-[#E9EFE5] transition">Login</a>
                        </div>
                    </div>
                @endguest

                @auth
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-red-600 hover:underline">Logout</button>
                        </form>
                    </div>
                @endauth

                <!-- Hamburger (mobile only) -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-700 hover:text-green-700">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileOpen"
         x-transition
         class="md:hidden bg-[#E9EFE5] border-t border-gray-200 px-4 py-4 space-y-3">

        @if (Auth::check() && Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Products</a>
            <a href="{{ route('admin.branches.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Branches</a>
            <a href="{{ route('admin.orders') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Orders</a>
            <a href="{{ route('admin.blogs.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Blogs</a>
            <a href="{{ route('admin.price-requests.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Price Requests</a>
            <a href="{{ route('admin.contact') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Contact</a>
        @elseif (Auth::check() && Auth::user()->isBranch())
            <a href="{{ route('branch.dashboard') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Dashboard</a>
            <a href="{{ route('branch.products.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Products</a>
            <a href="{{ route('branch.orders') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Orders</a>
            <a href="{{ route('branch.price-requests.index') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Price Requests</a>
        @else
            <a href="/" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Home</a>
            <a href="/products" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Products</a>
            <a href="/blogs" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Blogs</a>
            @auth
                @if(Auth::user()->isCustomer())
                    <a href="{{ route('customer.orders') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Orders</a>
                @endif
            @endauth
            <a href="/contact" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Contact Us</a>
        @endif

        <div class="border-t border-gray-200 pt-3">
            @guest
                <a href="{{ route('login') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium mb-2">Login</a>
                <a href="{{ route('register') }}" class="block text-gray-700 hover:text-green-700 text-sm font-medium">Register</a>
            @endguest
            @auth
                <span class="block text-sm text-gray-700 mb-2">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">Logout</button>
                </form>
            @endauth
        </div>

    </div>

</nav>
