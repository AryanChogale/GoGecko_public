<x-app-layout>

    <style>
        .blog-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(7,104,7,0.13);
        }
        .blog-title {
            transition: color 0.2s ease;
        }
        .blog-card:hover .blog-title {
            color: #076807;
        }
    </style>

    <div class="min-h-screen bg-[#E9EFE5] py-12">

        <h1 class="text-3xl font-bold text-[#076807] text-center mb-10">Blogs</h1>

        <div class="max-w-6xl mx-auto px-6">

            @if ($categories->isNotEmpty())
                <div class="flex flex-wrap items-center justify-center gap-3 mb-8">
                    <a href="{{ route('blogs.index') }}"
                       class="px-4 py-2 rounded-full text-sm font-medium transition {{ $selectedCategory ? 'bg-white text-gray-600 border border-gray-200 hover:border-[#076807] hover:text-[#076807]' : 'bg-[#076807] text-white shadow' }}">
                        All
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('blogs.index', ['category' => $category->id]) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition {{ $selectedCategory === $category->id ? 'bg-[#076807] text-white shadow' : 'bg-white text-gray-600 border border-gray-200 hover:border-[#076807] hover:text-[#076807]' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($blogs as $blog)
                    <a href="{{ route('blogs.show', $blog->slug) }}"
                       class="blog-card bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col">

                        {{-- Image --}}
                        <div class="overflow-hidden h-52 bg-gray-100">
                            @if ($blog->image_path)
                                <img src="{{ Storage::url($blog->image_path) }}"
                                     alt="{{ $blog->title }}"
                                     class="w-full h-full object-cover transition duration-500 hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#E9EFE5]">
                                    <span class="text-[#076807] text-4xl font-bold opacity-20">GG</span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex flex-col flex-1">

                            {{-- Category pill --}}
                            @if ($blog->category_name)
                                <span class="inline-block self-start text-xs font-semibold text-[#076807] bg-[#E9EFE5] px-3 py-1 rounded-full mb-3">
                                    {{ $blog->category_name }}
                                </span>
                            @endif

                            {{-- Title --}}
                            <h2 class="blog-title text-base font-bold text-gray-900 mb-3 leading-snug flex-1">
                                {{ $blog->title }}
                            </h2>

                            {{-- Excerpt --}}
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                                {{ $blog->excerpt }}
                            </p>

                            {{-- Footer --}}
                            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100 text-xs text-gray-400">
                                <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                <span>{{ $blog->reading_time }} min read</span>
                            </div>

                        </div>
                    </a>
                @empty
                    <div class="col-span-3 bg-white rounded-xl shadow p-16 text-center border border-gray-100">
                        <p class="text-gray-400">No posts yet.</p>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($blogs->hasPages())
                <div class="mt-10">{{ $blogs->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
