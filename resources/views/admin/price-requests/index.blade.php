<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#076807]">Price Change Requests</h1>
                    <p class="text-sm text-gray-500 mt-1">Pending requests from branches</p>
                </div>
                <a href="{{ route('admin.price-requests.history') }}"
                   class="text-sm font-medium text-[#076807] hover:text-green-900 border border-[#076807] px-4 py-2 rounded-full transition">
                    View History →
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

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
                            <p class="text-lg font-bold text-gray-400 line-through">₹{{ number_format($req->current_price, 2) }}</p>
                            <div class="text-[#076807] text-lg my-1">↓</div>
                            <p class="text-lg font-bold text-[#076807]">₹{{ number_format($req->requested_price, 2) }}</p>
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

                        {{-- Actions --}}
                        <div class="col-span-1 px-6 py-5 flex flex-col justify-center gap-3">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Final Price</p>
                            <form method="POST"
                                  action="{{ route('admin.price-requests.approve', $req) }}"
                                  class="space-y-2">
                                @csrf
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">₹</span>
                                    <input type="number"
                                           name="final_price"
                                           value="{{ $req->requested_price }}"
                                           step="0.01" min="0"
                                           class="w-full border border-gray-200 rounded-lg pl-6 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>
                                <button type="submit"
                                        class="w-full bg-[#076807] hover:bg-green-900 text-white text-sm font-medium py-2 rounded-lg transition">
                                    Approve
                                </button>
                            </form>
                            <form method="POST"
                                  action="{{ route('admin.price-requests.reject', $req) }}">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Reject this request?')"
                                        class="w-full border border-red-200 text-red-500 hover:bg-red-50 text-sm font-medium py-2 rounded-lg transition">
                                    Reject
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                    <p class="text-gray-400">No pending requests.</p>
                </div>
            @endforelse

            @if ($requests->hasPages())
                <div class="mt-6">{{ $requests->links() }}</div>
            @endif

        </div>
    </div>

</x-app-layout>
