<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('admin.blogs.index') }}"
                   class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                    &larr; Back to Blog Posts
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

                    <div class="col-span-2 space-y-5">
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
                                    <div class="relative">
                                        <input type="text" name="category" id="blog-category-input"
                                               value="{{ old('category') }}"
                                               placeholder="e.g. Cleaning"
                                               autocomplete="off"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                        <div id="blog-category-suggestions"
                                             class="hidden absolute z-10 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg overflow-hidden"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">Choose an existing blog category or type a new one.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between gap-3 mb-5">
                                <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Blog Content</h2>
                                <p class="text-xs text-gray-400">Use the toolbar for headings, lists, quotes, links, and inline formatting.</p>
                            </div>

                            <input type="hidden" name="content" id="content-input" value="{{ old('content') }}">
                            <div id="editor"
                                 class="rounded-xl border border-gray-200 overflow-hidden bg-white min-h-[22rem]"></div>
                            @error('content')
                                <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-1 space-y-5">
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

    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
        const blogCategories = @json($categories->values());
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your blog post here...',
            modules: {
                toolbar: [
                    [{ header: [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'link'],
                    ['clean'],
                ],
            },
        });

        const initialContent = @json(old('content', ''));
        if (initialContent) {
            quill.clipboard.dangerouslyPasteHTML(initialContent);
        }

        document.querySelector('form[action="{{ route('admin.blogs.store') }}"]').addEventListener('submit', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });

        const categoryInput = document.getElementById('blog-category-input');
        const categorySuggestions = document.getElementById('blog-category-suggestions');

        function hideCategorySuggestions() {
            categorySuggestions.classList.add('hidden');
            categorySuggestions.innerHTML = '';
        }

        function showCategorySuggestions(query) {
            const normalized = query.trim().toLowerCase();

            if (normalized.length < 1) {
                hideCategorySuggestions();
                return;
            }

            const matches = blogCategories.filter(category => category.toLowerCase().includes(normalized));

            if (matches.length === 0) {
                hideCategorySuggestions();
                return;
            }

            categorySuggestions.innerHTML = matches.map(category => `
                <button type="button" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-[#E9EFE5]">
                    ${category}
                </button>
            `).join('');

            categorySuggestions.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', () => {
                    categoryInput.value = button.textContent.trim();
                    hideCategorySuggestions();
                });
            });

            categorySuggestions.classList.remove('hidden');
        }

        categoryInput.addEventListener('input', function () {
            showCategorySuggestions(this.value);
        });

        categoryInput.addEventListener('focus', function () {
            if (this.value.trim() !== '') {
                showCategorySuggestions(this.value);
            }
        });

        document.addEventListener('click', function (event) {
            if (!categoryInput.contains(event.target) && !categorySuggestions.contains(event.target)) {
                hideCategorySuggestions();
            }
        });

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
