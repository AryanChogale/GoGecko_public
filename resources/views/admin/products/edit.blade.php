<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('admin.products.index') }}"
                       class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                        ← Back to Products
                    </a>
                    <h1 class="text-2xl font-bold text-[#076807]">Edit Product</h1>
                </div>
                {{-- Danger zone --}}
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')"
                            class="text-sm text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-4 py-2 rounded-lg transition">
                        Delete Product
                    </button>
                </form>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.products.update', $product) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT - main fields --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Basic Info card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Basic Info</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name"
                                           value="{{ old('name', $product->name) }}" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" rows="4"
                                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Categorisation card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Categorisation</h2>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="category"
                                           value="{{ old('category', $product->category) }}" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Sub-category <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="sub_category"
                                           value="{{ old('sub_category', $product->sub_category) }}" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                            </div>
                        </div>

                        {{-- Pricing card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Pricing & Stock</h2>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Price (₹) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                        <input type="number" name="price"
                                               value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                               class="w-full border border-gray-200 rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Quantity <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="quantity"
                                           value="{{ old('quantity', $product->quantity) }}" min="0" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT - image + save --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Current image card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Image</h2>

                            @php
                                $imgSrc = Str::startsWith($product->image_path ?? '', 'http')
                                    ? $product->image_path
                                    : ($product->image_path ? Storage::url($product->image_path) : null);
                            @endphp

                            @if ($imgSrc)
                                <img src="{{ $imgSrc }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-contain rounded-lg bg-[#E9EFE5] mb-4 p-2">
                            @else
                                <div class="w-full h-48 rounded-lg bg-[#E9EFE5] flex items-center justify-center mb-4">
                                    <span class="text-[#076807] opacity-30 text-4xl font-bold">GG</span>
                                </div>
                            @endif

                            <label class="block text-xs font-medium text-gray-500 mb-2">
                                {{ $imgSrc ? 'Replace image' : 'Upload image' }}
                            </label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-medium file:bg-[#E9EFE5] file:text-[#076807] hover:file:bg-green-100">
                        </div>

                        {{-- Save card --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">Review your changes before saving</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.products.index') }}"
                               class="block text-green-300 hover:text-white text-xs mt-3 transition">
                                Cancel
                            </a>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
