<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#076807]">Branches</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage branch accounts and locations</p>
                </div>
                <a href="{{ route('admin.branches.create') }}"
                   class="bg-[#076807] hover:bg-green-900 text-white text-sm font-medium px-5 py-2.5 rounded-full transition shadow">
                    + Add Branch
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cards grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($branches as $branch)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">

                        {{-- Card header --}}
                        <div class="bg-[#076807] px-5 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-white font-bold text-base">{{ $branch->name }}</h3>
                                    @if ($branch->city)
                                        <p class="text-green-200 text-xs mt-0.5">{{ $branch->city }}</p>
                                    @endif
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Card body --}}
                        <div class="px-5 py-4 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                @if ($branch->address)
                                    <div class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#076807] mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-xs leading-relaxed">{{ $branch->address }}</span>
                                    </div>
                                @endif

                                @if ($branch->phone)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#076807] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span class="text-xs">{{ $branch->phone }}</span>
                                    </div>
                                @endif

                                @if ($branch->user?->email)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#076807] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs">{{ $branch->user->email }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Geocoded badge always at bottom --}}
                            <div class="flex items-center gap-2 pt-3">
                                @if ($branch->latitude && $branch->longitude)
                                    <span class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Geocoded
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                        No coordinates
                                    </span>
                                @endif
                            </div>

                        </div>

                        {{-- Card footer --}}
                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('admin.branches.edit', $branch) }}"
                               class="text-sm font-medium text-[#076807] hover:text-green-900 transition">
                                Edit
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.branches.destroy', $branch) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete {{ addslashes($branch->name) }} and its login account?')"
                                        class="text-sm text-red-500 hover:text-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 bg-white rounded-xl p-16 text-center border border-gray-100">
                        <p class="text-gray-400 mb-2">No branches yet.</p>
                        <a href="{{ route('admin.branches.create') }}"
                           class="text-[#076807] hover:underline text-sm">Add your first branch</a>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($branches->hasPages())
                <div class="mt-8">{{ $branches->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
