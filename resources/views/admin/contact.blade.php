<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#076807]">Contact Submissions</h1>
                <p class="text-sm text-gray-500 mt-1">Messages received from the contact form</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">

                @forelse ($submissions as $submission)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                        <div class="grid grid-cols-5 divide-x divide-gray-100">

                            {{-- Sender info --}}
                            <div class="col-span-1 px-6 py-5">
                                <div class="w-10 h-10 rounded-full bg-[#E9EFE5] flex items-center justify-center mb-3">
                                    <span class="text-[#076807] font-bold text-sm">
                                        {{ strtoupper(substr($submission->full_name, 0, 1)) }}
                                    </span>
                                </div>
                                <p class="font-bold text-gray-800 text-sm">{{ $submission->full_name }}</p>
                                <p class="text-xs text-gray-400 mt-3">{{ $submission->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $submission->created_at->format('h:i A') }}</p>
                            </div>

                            {{-- Contact details --}}
                            <div class="col-span-1 px-6 py-5 flex flex-col justify-center">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#076807] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:{{ $submission->email }}"
                                       class="text-xs text-gray-600 hover:text-[#076807] transition break-all">
                                        {{ $submission->email }}
                                    </a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#076807] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <a href="tel:{{ $submission->phone }}"
                                       class="text-xs text-gray-600 hover:text-[#076807] transition">
                                        {{ $submission->phone }}
                                    </a>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="col-span-3 px-6 py-5 flex items-start justify-between gap-4">
                                <div class="flex-1" x-data="{ expanded: false }">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Message</p>
                                    <p class="text-sm text-gray-600 leading-relaxed break-words"
                                       :class="expanded ? '' : 'line-clamp-2'">{{ $submission->message }}</p>
                                    @if (strlen($submission->message) > 150)
                                        <button @click="expanded = !expanded"
                                                class="text-xs text-[#076807] hover:text-green-900 font-medium mt-1 transition">
                                            <span x-text="expanded ? 'Show less ↑' : 'Read more ↓'"></span>
                                        </button>
                                    @endif
                                </div>

                                {{-- Delete --}}
                                <div class="shrink-0">
                                    <form method="POST"
                                          action="{{ route('admin.contact.destroy', $submission) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Delete this submission?')"
                                                class="text-xs text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                        <p class="text-gray-400">No submissions yet.</p>
                    </div>
                @endforelse

            </div>

            @if ($submissions->hasPages())
                <div class="mt-8">{{ $submissions->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
