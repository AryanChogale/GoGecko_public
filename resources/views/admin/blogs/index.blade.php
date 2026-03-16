<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#076807]">Blog Posts</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage your published articles</p>
                </div>
                <a href="{{ route('admin.blogs.create') }}"
                   class="bg-[#076807] hover:bg-green-900 text-white text-sm font-medium px-5 py-2.5 rounded-full transition shadow">
                    + New Post
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">

                @forelse ($blogs as $blog)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="flex items-stretch">

                            {{-- Image --}}
                            <div class="w-36 shrink-0 bg-[#E9EFE5] flex items-center justify-center overflow-hidden">
                                @if ($blog->image_path)
                                    <img src="{{ Storage::url($blog->image_path) }}"
                                         alt="{{ $blog->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-[#076807] text-2xl font-bold opacity-20">GG</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 px-6 py-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        @if ($blog->category)
                                            <span class="text-xs font-semibold text-[#076807] bg-[#E9EFE5] px-3 py-1 rounded-full">
                                                {{ $blog->category }}
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-400">{{ $blog->reading_time }} min read</span>
                                        <span class="text-xs text-gray-400">{{ $blog->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h2 class="font-bold text-gray-900 text-base mb-1">{{ $blog->title }}</h2>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $blog->excerpt }}</p>
                                </div>
                                <div class="flex items-center gap-2 mt-3 text-xs text-gray-400">
                                    <span class="font-mono text-gray-300">/blogs/{{ $blog->slug }}</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex flex-col justify-center items-center gap-3 px-6 border-l border-gray-100">
                                <a href="{{ route('blogs.show', $blog->slug) }}"
                                   target="_blank"
                                   class="text-xs text-gray-400 hover:text-[#076807] transition whitespace-nowrap">
                                    View ↗
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                   class="bg-[#076807] hover:bg-green-900 text-white text-xs font-medium px-4 py-2 rounded-full transition whitespace-nowrap">
                                    Edit
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.blogs.destroy', $blog) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this post?')"
                                            class="text-xs text-red-500 hover:text-red-700 transition whitespace-nowrap">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                        <p class="text-gray-400 mb-2">No blog posts yet.</p>
                        <a href="{{ route('admin.blogs.create') }}"
                           class="text-[#076807] hover:underline text-sm">Write your first post</a>
                    </div>
                @endforelse

            </div>

            @if ($blogs->hasPages())
                <div class="mt-8">{{ $blogs->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
