<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#076807]">Price Change Requests</h1>
                    <p class="text-sm text-gray-500 mt-1">Your branch's submitted requests</p>
                </div>
                <a href="{{ route('branch.price-requests.create') }}"
                   class="bg-[#076807] hover:bg-green-900 text-white text-sm font-medium px-5 py-2.5 rounded-full transition shadow">
                    + New Request
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">

                @forelse ($requests as $req)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                        <div class="grid grid-cols-4 divide-x divide-gray-100">

                            {{-- Product --}}
                            <div class="col-span-1 px-6 py-5">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Product</p>
                                <p class="font-bold text-gray-800 text-sm">{{ $req->product->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $req->product->subcategory?->category?->name }}</p>
                            </div>

                            {{-- Price change --}}
                            <div class="col-span-1 px-6 py-5 flex flex-col justify-center items-center text-center">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Price Change</p>
                                <p class="text-base font-bold text-gray-400 line-through">₹{{ number_format($req->current_price, 2) }}</p>
                                <div class="text-[#076807] my-1">↓</div>
                                <p class="text-base font-bold text-[#076807]">₹{{ number_format($req->requested_price, 2) }}</p>
                                @php
                                    $diff = $req->requested_price - $req->current_price;
                                    $pct  = $req->current_price > 0 ? round(($diff / $req->current_price) * 100, 1) : 0;
                                @endphp
                                <span class="text-xs mt-1 px-2 py-0.5 rounded-full {{ $diff > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                    {{ $diff > 0 ? '+' : '' }}{{ $pct }}%
                                </span>
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
                                <p class="text-xs text-gray-400 mt-3">{{ $req->created_at->diffForHumans() }}</p>
                            </div>

                            {{-- Status --}}
                            <div class="col-span-1 px-6 py-5 flex flex-col justify-center items-center text-center">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Status</p>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold
                                    {{ $req->status === 'pending'  ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $req->status === 'approved' ? 'bg-green-100 text-green-700'   : '' }}
                                    {{ $req->status === 'rejected' ? 'bg-red-100 text-red-600'       : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $req->status === 'pending'  ? 'bg-yellow-400' : '' }}
                                        {{ $req->status === 'approved' ? 'bg-green-500'  : '' }}
                                        {{ $req->status === 'rejected' ? 'bg-red-500'    : '' }}">
                                    </span>
                                    {{ ucfirst($req->status) }}
                                </span>
                                @if ($req->status === 'approved' && $req->final_price)
                                    <p class="text-xs text-gray-400 mt-2">Final price</p>
                                    <p class="text-sm font-bold text-[#076807]">₹{{ number_format($req->final_price, 2) }}</p>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                        <p class="text-gray-400 mb-2">No requests yet.</p>
                        <a href="{{ route('branch.price-requests.create') }}"
                           class="text-[#076807] hover:underline text-sm">Submit your first request</a>
                    </div>
                @endforelse

            </div>

            @if ($requests->hasPages())
                <div class="mt-8">{{ $requests->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>

