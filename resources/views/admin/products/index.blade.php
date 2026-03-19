<x-app-layout>

    <div class="py-10 bg-[#E9EFE5] min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-4 gap-10">

                {{-- Sidebar --}}
                <div class="col-span-1">

                    <div class="mb-6 flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-[#076807]">Products</h1>
                        <a href="{{ route('admin.products.create') }}"
                           class="bg-[#076807] hover:bg-green-900 text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                            + Add
                        </a>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
                        <input type="text"
                               id="searchbar"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search..."
                               class="w-full border rounded-full px-4 py-2 text-sm focus:outline-none">

                        {{-- Categories --}}
                        <h3 class="text-gray-600 font-semibold mb-3 mt-6">Categories</h3>
                        <div class="space-y-3 text-gray-600 text-sm">
                            <a href="{{ route('admin.products.index') }}"
                               class="block hover:text-green-600 {{ !request('category') ? 'text-green-600 font-semibold' : '' }}">
                                All Products
                            </a>
                            @foreach ($categories as $cat)
                                <a href="{{ route('admin.products.index', ['category' => $cat]) }}"
                                   class="block hover:text-green-600 {{ request('category') == $cat ? 'text-green-600 font-semibold' : '' }}">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </form>

                </div>

                {{-- Products Grid --}}
                <div class="col-span-3">

                    <div class="grid grid-cols-3 gap-8">

                        @forelse ($products as $product)
                            <div class="bg-white shadow rounded-lg p-6 text-center flex flex-col hover:shadow-xl transition">

                                {{-- Image --}}
                                <a href="{{ route('admin.products.edit', $product) }}">
                                    @php
                                        $imgSrc = Str::startsWith($product->image_path ?? '', 'http')
                                            ? $product->image_path
                                            : ($product->image_path ? Storage::url($product->image_path) : null);
                                    @endphp

                                    @if ($imgSrc)
                                        <div class="h-48 flex items-center justify-center overflow-hidden">
                                            <img src="{{ $imgSrc }}"
                                                 class="max-h-full object-contain transition duration-300 hover:scale-110">
                                        </div>
                                    @else
                                        <div class="h-48 flex items-center justify-center bg-gray-100 text-gray-400 text-sm">
                                            No image
                                        </div>
                                    @endif
                                </a>

                                {{-- Name --}}
                                <p class="text-gray-700 font-medium mt-4 text-sm">
                                    {{ $product->name }}
                                </p>

                                {{-- Category --}}
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $product->category }} · {{ $product->sub_category }}
                                </p>

                                {{-- Price --}}
                                <p class="text-sm font-semibold text-[#076807] mt-2">
                                    ₹{{ number_format($product->price, 2) }}
                                </p>

                                {{-- Actions --}}
                                <div class="mt-4 flex flex-col gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="bg-[#076807] hover:bg-green-900 text-white px-6 py-2 rounded-full text-sm transition">
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Delete {{ addslashes($product->name) }}?')"
                                                class="text-red-600 hover:underline text-sm bg-transparent">
                                            Remove
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-3 bg-white rounded-lg p-12 text-center text-gray-400">
                                No products found.
                                <a href="{{ route('admin.products.create') }}" class="text-[#076807] hover:underline ml-1">Add one.</a>
                            </div>
                        @endforelse

                    </div>

                    {{-- Pagination --}}
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
