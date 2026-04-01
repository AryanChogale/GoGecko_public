<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('admin.blogs.index') }}"
                   class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                    ← Back to Blog Posts
                </a>
                <h1 class="text-2xl font-bold text-[#076807]">New Blog Post</h1>
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
                  action="{{ route('admin.blogs.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Basic Info --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Basic Info</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title"
                                           value="{{ old('title') }}" required
                                           placeholder="e.g. Why Smart Packaging Matters"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    <p class="text-xs text-gray-400 mt-1">Slug is auto-generated from title.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Excerpt <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="excerpt" rows="2" required
                                              placeholder="2-3 sentence summary shown on blog list..."
                                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('excerpt') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Category <span class="text-gray-400 text-xs">(optional)</span>
                                    </label>
                                    <select name="category"
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                        <option value="">— No category —</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Content Blocks --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Content Blocks</h2>

                            <div id="blocks-container" class="space-y-4">
                                <div class="block-item border border-gray-200 rounded-xl p-5 relative bg-[#f9fbf9]">
                                    <p class="text-xs font-bold text-[#076807] uppercase mb-4">Block 1</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Header</label>
                                            <input type="text" name="blocks[0][header]"
                                                   value="{{ old('blocks.0.header') }}"
                                                   placeholder="Big heading..."
                                                   class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Sub-header</label>
                                            <input type="text" name="blocks[0][subheader]"
                                                   value="{{ old('blocks.0.subheader') }}"
                                                   placeholder="Medium heading..."
                                                   class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Content</label>
                                            <textarea name="blocks[0][content]" rows="4"
                                                      placeholder="Paragraph text..."
                                                      class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white resize-none">{{ old('blocks.0.content') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button"
                                    onclick="addBlock()"
                                    class="mt-4 w-full border-2 border-dashed border-[#076807] text-[#076807] hover:bg-[#076807] hover:text-white rounded-xl py-3 text-sm font-medium transition">
                                + Add Block
                            </button>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Cover image --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Cover Image</h2>
                            <div class="w-full h-40 rounded-lg bg-[#E9EFE5] flex items-center justify-center mb-4" id="image-preview-wrapper">
                                <img id="image-preview" src="" alt="" class="hidden w-full h-full object-cover rounded-lg">
                                <span id="image-placeholder" class="text-[#076807] opacity-30 text-4xl font-bold">GG</span>
                            </div>
                            <input type="file" name="image" accept="image/*" id="image-input"
                                   class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-medium file:bg-[#E9EFE5] file:text-[#076807] hover:file:bg-green-100">
                            <p class="text-xs text-gray-400 mt-2">Optional. Max 2MB.</p>
                        </div>

                        {{-- Publish --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">Post will be published immediately</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Publish Post
                            </button>
                            <a href="{{ route('admin.blogs.index') }}"
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
        let blockCount = 1;

        function addBlock() {
            const container = document.getElementById('blocks-container');
            const index = blockCount;
            blockCount++;

            const block = document.createElement('div');
            block.className = 'block-item border border-gray-200 rounded-xl p-5 relative bg-[#f9fbf9]';
            block.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-[#076807] uppercase">Block ${blockCount}</p>
                    <button type="button" onclick="removeBlock(this)"
                            class="text-xs text-red-500 hover:text-red-700">Remove</button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Header</label>
                        <input type="text" name="blocks[${index}][header]"
                               placeholder="Big heading..."
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sub-header</label>
                        <input type="text" name="blocks[${index}][subheader]"
                               placeholder="Medium heading..."
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Content</label>
                        <textarea name="blocks[${index}][content]" rows="4"
                                  placeholder="Paragraph text..."
                                  class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white resize-none"></textarea>
                    </div>
                </div>
            `;
            container.appendChild(block);
        }

        function removeBlock(btn) {
            btn.closest('.block-item').remove();
        }

        document.getElementById('image-input').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>

</x-app-layout>
