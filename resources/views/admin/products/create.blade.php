<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Page Header --}}
            <div class="mb-8">
                <a href="{{ route('admin.products.index') }}"
                   class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                    ← Back to Products
                </a>
                <h1 class="text-2xl font-bold text-[#076807]">Add Product</h1>
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
                  action="{{ route('admin.products.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT — main fields --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Basic Info --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Basic Info</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name"
                                           value="{{ old('name') }}" required
                                           placeholder="e.g. Brown Kraft Paper Box"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" rows="4"
                                              placeholder="Brief description of the product..."
                                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Categorisation --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Categorisation</h2>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="category"
                                           value="{{ old('category') }}" required
                                           placeholder="e.g. Packaging Products"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Sub-category <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="sub_category"
                                           value="{{ old('sub_category') }}" required
                                           placeholder="e.g. Boxes"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                            </div>
                        </div>

                        {{-- Pricing & Stock --}}
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
                                               value="{{ old('price') }}" step="0.01" min="0" required
                                               placeholder="0.00"
                                               class="w-full border border-gray-200 rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Quantity <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="quantity"
                                           value="{{ old('quantity') }}" min="0" required
                                           placeholder="0"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT — image + save --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Image upload card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Image</h2>

                            <div class="w-full h-48 rounded-lg bg-[#E9EFE5] flex items-center justify-center mb-4" id="image-preview-wrapper">
                                <img id="image-preview" src="" alt="" class="hidden w-full h-full object-contain rounded-lg p-2">
                                <span id="image-placeholder" class="text-[#076807] opacity-30 text-4xl font-bold">GG</span>
                            </div>

                            <label class="block text-xs font-medium text-gray-500 mb-2">Upload image</label>
                            <input type="file" name="image" accept="image/*"
                                   id="image-input"
                                   class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-medium file:bg-[#E9EFE5] file:text-[#076807] hover:file:bg-green-100">
                            <p class="text-xs text-gray-400 mt-2">Max 2MB. JPG, PNG, WebP.</p>
                        </div>

                        {{-- Save card --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">Fill in all required fields before publishing</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Create Product
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

    <script>
        document.getElementById('image-input').addEventListener('change', function () {
            const file = this.files[0]
            if (!file) return

            const reader = new FileReader()
            reader.onload = function (e) {
                const preview = document.getElementById('image-preview')
                const placeholder = document.getElementById('image-placeholder')
                preview.src = e.target.result
                preview.classList.remove('hidden')
                placeholder.classList.add('hidden')
            }
            reader.readAsDataURL(file)
        })
    </script>

</x-app-layout>
