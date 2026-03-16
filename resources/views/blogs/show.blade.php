<x-app-layout>

    <style>
        .back-link {
            transition: color 0.2s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .back-link:hover {
            color: #076807;
            transform: translateX(-2px);
        }
        .content-block h2 {
            color: #076807;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            margin-top: 0.5rem;
        }
        .content-block h3 {
            color: #1a1a1a;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }
        .content-block p {
            color: #4b5563;
            line-height: 1.8;
            font-size: 1rem;
        }
    </style>

    <div class="min-h-screen bg-[#E9EFE5] py-12">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Back link --}}
            <a href="{{ route('blogs.index') }}" class="back-link text-sm text-gray-500 font-medium mb-6 inline-flex">
                ← Back to Blog
            </a>

            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mt-4">

                {{-- Hero image — only if exists --}}
                @if ($blog->image_path)
                    <img src="{{ Storage::url($blog->image_path) }}"
                         alt="{{ $blog->title }}"
                         class="w-full max-h-80 object-cover">
                @endif

                <div class="px-8 py-8">

                    {{-- Category pill + meta --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        @if ($blog->category)
                            <span class="text-xs font-semibold text-[#076807] bg-[#E9EFE5] px-3 py-1 rounded-full">
                                {{ $blog->category }}
                            </span>
                        @endif
                        <span class="text-xs text-gray-400">
                            {{ $blog->created_at->format('M d, Y') }} &middot; {{ $blog->reading_time }} min read
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl font-bold text-gray-900 mb-8 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    {{-- Content blocks --}}
                    <div class="content-block space-y-6">
                        @foreach ($blog->content as $block)
                            <div>
                                @if (!empty($block['header']))
                                    <h2>{{ $block['header'] }}</h2>
                                @endif
                                @if (!empty($block['subheader']))
                                    <h3>{{ $block['subheader'] }}</h3>
                                @endif
                                @if (!empty($block['content']))
                                    <p>{{ $block['content'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Bottom back link --}}
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <a href="{{ route('blogs.index') }}" class="back-link text-sm text-gray-500 font-medium">
                            ← Back to Blog
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
