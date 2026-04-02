<x-app-layout>

<div class="py-10 bg-[#E9EFE5] min-h-screen">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Title -->
        <h1 class="text-4xl text-center text-gray-600 font-semibold mb-10">
            Our Products
        </h1>

        @if (session('error'))
            <div class="max-w-4xl mx-auto mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif


        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-10">


            <!-- Sidebar -->
            <div class="col-span-1 md:col-span-1">

                <form method="GET" action="{{ route('products.index') }}" class="mb-8">

                    <!-- Search -->
                    <div class="relative mb-6">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search..."
                            class="w-full border rounded-full px-4 py-2 text-sm focus:outline-none"
                            id="searchbar">
                    </div>


                    <!-- Categories -->
                    <h3 class="text-gray-600 font-semibold mb-4">
                        Product Categories
                    </h3>

                    <div class="space-y-3 text-gray-600 text-sm">

                        <a href="{{ route('products.index') }}"
                           class="block hover:text-green-600 {{ !request('category') && !request('search') ? 'text-green-600 font-semibold' : '' }}">
                            All Products
                        </a>

                        @foreach ($categories as $cat)

                            <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                            class="block hover:text-green-600 {{ (string) request('category') === (string) $cat->id ? 'text-green-600 font-semibold' : '' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach

                    </div>

                </form>

            </div>



            <!-- Products -->
            <div class="col-span-1 md:col-span-3">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">

                    @forelse ($products as $product)

                    <div class="bg-white shadow rounded-lg p-6 text-center flex flex-col hover:shadow-xl transition">


                        <!-- Image -->
                        <a href="{{ route('products.show', $product) }}">

                            @if ($product->image_path)

                            @php
                                $imgSrc = Str::startsWith($product->image_path, 'http')
                                    ? $product->image_path
                                    : Storage::url($product->image_path);
                            @endphp

                            <div class="h-48 flex items-center justify-center overflow-hidden">

                                <img
                                    src="{{ $imgSrc }}"
                                    class="max-h-full object-contain transition duration-300 hover:scale-110">

                            </div>

                            @else

                            <div class="h-48 flex items-center justify-center bg-gray-100 text-gray-400 text-sm">
                                No image
                            </div>

                            @endif

                        </a>


                        <!-- Product Name -->
                        <p class="text-gray-600 mt-4 text-sm">
                            {{ $product->name }}
                        </p>
                        <p class="text-[#076807] font-semibold text-sm mt-1">
                            ₹{{ number_format($product->priceForBranch($branchId ?? null), 2) }}
                        </p>

                        <p class="text-xs mt-2 {{ $product->quantity > 0 ? 'text-gray-500' : 'text-red-500 font-semibold' }}">
                            {{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of stock' }}
                        </p>



                        <!-- Add to Cart Form -->
                        <form method="POST"
                              action="{{ route('cart.store') }}"
                              class="add-to-cart-form mt-4">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="flex items-center justify-center gap-4 mt-2">

                                <button type="button" class="qty-minus text-lg px-2">−</button>

                                <input
                                    type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ max($product->quantity, 1) }}"
                                    {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                    class="qty-input w-14 text-center border rounded">

                                <span class="text-sm text-gray-500">
                                    Single
                                </span>

                                <button type="button" class="qty-plus text-lg px-2">+</button>

                            </div>

                            <p class="text-xs text-gray-500 mt-2">
                                1 units per Single
                            </p>

                            <button
                                type="submit"
                                {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                class="{{ $product->quantity > 0 ? 'bg-green-600 hover:bg-green-500' : 'bg-gray-300 cursor-not-allowed' }} text-white px-6 py-2 rounded-full text-sm mt-4">
                                {{ $product->quantity > 0 ? 'Add To Cart' : 'Out of Stock' }}
                            </button>

                        </form>


                    </div>

                    @empty

                    <p class="text-gray-400">No products found.</p>

                    @endforelse

                </div>


                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>


            </div>

        </div>

    </div>

</div>

</x-app-layout>
