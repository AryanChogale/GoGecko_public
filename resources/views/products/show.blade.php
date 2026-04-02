<x-app-layout>

    <div class="py-8 bg-[#E9EFE5] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <a href="{{ route('products.index') }}"
               class="text-sm text-gray-500 hover:text-[#076807] transition mb-6 inline-block">
                ← Back to Products
            </a>

            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="md:flex">

                    {{-- Image --}}
                    <div class="md:w-1/2 bg-[#E9EFE5] flex items-center justify-center p-6">
                        @if ($product->image_path)
                            @php
                                $imgSrc = Str::startsWith($product->image_path, 'http')
                                    ? $product->image_path
                                    : Storage::url($product->image_path);
                            @endphp
                            <img src="{{ $imgSrc }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-72 object-contain">
                        @else
                            <div class="w-full h-72 flex items-center justify-center text-[#076807] opacity-20">
                                <span class="text-6xl font-bold">GG</span>
                            </div>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="md:w-1/2 p-8 flex flex-col">

                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                            {{ $product->subcategory?->category?->name }}
                            @if ($product->subcategory?->name)
                                · {{ $product->subcategory?->name }}
                            @endif
                        </p>

                        <h1 class="text-2xl font-bold text-gray-900 mb-3">
                            {{ $product->name }}
                        </h1>

                        <p class="text-3xl font-bold text-[#076807] mb-4">
                            ₹{{ number_format($product->price, 2) }}
                        </p>

                        <p class="text-sm mb-4 {{ $product->quantity > 0 ? 'text-gray-500' : 'text-red-500 font-semibold' }}">
                            {{ $product->quantity > 0 ? $product->quantity . ' units available' : 'Out of stock' }}
                        </p>

                        @if ($product->description)
                            <p class="text-sm text-gray-600 leading-relaxed mb-6">
                                {{ $product->description }}
                            </p>
                        @endif

                        <form method="POST" action="{{ route('cart.store') }}" class="add-to-cart-form mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center gap-3 mb-4">
                                <label class="text-sm text-gray-600">Qty:</label>
                                <input type="number" name="quantity" value="1" min="1"
                                       max="{{ max($product->quantity, 1) }}"
                                       {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                       class="w-20 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                            </div>
                            <button type="submit"
                                    {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                    class="w-full {{ $product->quantity > 0 ? 'bg-[#076807] hover:bg-green-900' : 'bg-gray-300 cursor-not-allowed' }} text-white font-semibold py-3 rounded-full transition">
                                {{ $product->quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>

