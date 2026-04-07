<x-app-layout>

    <div class="py-10 bg-[#E9EFE5] min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-10">

                <div class="col-span-1">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-[#076807]">Products</h1>
                    </div>

                    <form method="GET" action="{{ route('branch.products.index') }}" class="mb-6">
                        <input type="text"
                               id="searchbar"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search..."
                               class="w-full border rounded-full px-4 py-2 text-sm focus:outline-none">

                        <h3 class="text-gray-600 font-semibold mb-3 mt-6">Categories</h3>
                        <div class="space-y-3 text-gray-600 text-sm">
                            <a href="{{ route('branch.products.index') }}"
                               class="block hover:text-green-600 {{ !request('category') ? 'text-green-600 font-semibold' : '' }}">
                                All Products
                            </a>
                            @foreach ($categories as $cat)
                                <a href="{{ route('branch.products.index', ['category' => $cat->id]) }}"
                                   class="block hover:text-green-600 {{ (string) request('category') === (string) $cat->id ? 'text-green-600 font-semibold' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>

                <div class="col-span-1 md:col-span-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">

                        @forelse ($products as $product)
                            @php
                                $priceRequestUrl = route('branch.price-requests.create', ['product' => $product->id]);
                                $imgSrc = Str::startsWith($product->image_path ?? '', 'http')
                                    ? $product->image_path
                                    : ($product->image_path ? Storage::url($product->image_path) : null);
                            @endphp

                            <div class="bg-white shadow rounded-lg p-6 text-center flex flex-col hover:shadow-xl transition">
                                <a href="{{ $priceRequestUrl }}">
                                    @if ($imgSrc)
                                        <div class="h-48 flex items-center justify-center overflow-hidden">
                                            <img src="{{ $imgSrc }}"
                                                 class="max-h-full object-contain transition duration-300 hover:scale-110"
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @else
                                        <div class="h-48 flex items-center justify-center bg-gray-100 text-gray-400 text-sm">
                                            No image
                                        </div>
                                    @endif
                                </a>

                                <p class="text-gray-700 font-medium mt-4 text-sm">
                                    {{ $product->name }}
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $product->subcategory?->category?->name }} · {{ $product->subcategory?->name }}
                                </p>

                                <p class="text-sm font-semibold text-[#076807] mt-2">
                                    ₹{{ number_format($product->priceForBranch($branchId), 2) }}
                                </p>

                                <p class="text-xs mt-1 {{ $product->quantity > 0 ? 'text-gray-500' : 'text-red-500 font-semibold' }}">
                                    Stock: {{ $product->quantity }}
                                </p>

                                <div class="mt-4">
                                    <a href="{{ $priceRequestUrl }}"
                                       class="block bg-[#076807] hover:bg-green-900 text-white px-6 py-2 rounded-full text-sm transition">
                                        Price Request
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-3 bg-white rounded-lg p-12 text-center text-gray-400">
                                No products found.
                            </div>
                        @endforelse

                    </div>

                    @if ($products->hasPages())
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
