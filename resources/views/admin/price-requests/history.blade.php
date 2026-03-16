<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#076807]">Price Change History</h1>
                    <p class="text-sm text-gray-500 mt-1">Approved and rejected requests</p>
                </div>
                <a href="{{ route('admin.price-requests.index') }}"
                   class="text-sm font-medium text-[#076807] hover:text-green-900 border border-[#076807] px-4 py-2 rounded-full transition">
                    ← Pending Requests
                </a>
            </div>

            @forelse ($requests as $req)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4 overflow-hidden">

                    <div class="grid grid-cols-5 gap-0 divide-x divide-gray-100">

                        {{-- Branch + Product --}}
                        <div class="col-span-2 px-6 py-5">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Branch</p>
                            <p class="font-bold text-[#076807] text-sm">{{ $req->branch->name }}</p>
                            <p class="text-xs text-gray-400 mt-3 uppercase tracking-wide mb-1">Product</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $req->product->name }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $req->product->category }}</p>
                        </div>

                        {{-- Price comparison --}}
                        <div class="col-span-1 px-6 py-5 flex flex-col justify-center items-center text-center">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Price Change</p>
                            <p class="text-sm font-bold text-gray-400 line-through">₹{{ number_format($req->current_price, 2) }}</p>
                            <div class="text-gray-400 text-sm my-1">↓</div>
                            <p class="text-sm font-bold text-gray-700">₹{{ number_format($req->requested_price, 2) }}</p>
                            @if ($req->final_price)
                                <p class="text-xs text-gray-400 mt-2">Final</p>
                                <p class="text-sm font-bold text-[#076807]">₹{{ number_format($req->final_price, 2) }}</p>
                            @endif
                        </div>

                        {{-- Reason --}}
                        <div class="col-span-1 px-6 py-5">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Reason</p>
                            <div x-data="{ expanded: false }">
                                <p class="text-sm text-gray-600 leading-relaxed break-words"
                                   :class="expanded ? '' : 'line-clamp-3'">{{ $req->reason }}</p>
                                @if (strlen($req->reason) > 120)
                                    <button @click="expanded = !expanded"
                                            class="text-xs text-[#076807] hover:text-green-900 font-medium mt-1 transition">
                                        <span x-text="expanded ? 'Show less ↑' : 'Read more ↓'"></span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Status + reviewer --}}
                        <div class="col-span-1 px-6 py-5 flex flex-col justify-center items-center text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold mb-3
                                {{ $req->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $req->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ ucfirst($req->status) }}
                            </span>
                            @if ($req->reviewer)
                                <p class="text-xs text-gray-400">by {{ $req->reviewer->name }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">{{ $req->updated_at->diffForHumans() }}</p>
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                    <p class="text-gray-400">No history yet.</p>
                </div>
            @endforelse

            @if ($requests->hasPages())
                <div class="mt-6">{{ $requests->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
