<x-app-layout>

    <div class="py-8 bg-[#E9EFE5] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-[#076807] mb-8">My Orders</h1>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            @forelse ($orders as $order)
                <div class="bg-white shadow rounded-lg mb-4 overflow-hidden border border-gray-100">

                    {{-- Order Header --}}
                    <div class="px-6 py-4 flex items-center justify-between cursor-pointer hover:bg-[#f0faf0] transition"
                         onclick="toggleOrder({{ $order->id }})">
                        <div class="flex items-center gap-6">
                            <div>
                                <p class="text-xs text-gray-400">Order</p>
                                <p class="font-semibold text-[#076807]">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Date</p>
                                <p class="text-sm text-gray-700">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Branch</p>
                                <p class="text-sm text-gray-700">{{ $order->branch->name }} — {{ $order->branch->city }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Total</p>
                                <p class="text-sm font-bold text-[#076807]">₹{{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs px-2 py-1 rounded-full font-medium
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order->status === 'out_for_delivery' ? 'bg-purple-100 text-purple-700' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            <span class="text-[#076807] text-sm" id="arrow-{{ $order->id }}">▼</span>
                        </div>
                    </div>

                    {{-- Order Details --}}
                    <div id="order-{{ $order->id }}" class="hidden border-t border-gray-100 bg-[#f7fdf7] px-6 py-4">

                        {{-- Items --}}
                        <h4 class="text-sm font-semibold text-[#076807] mb-3">Items</h4>
                        <div class="space-y-2 mb-4">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between text-sm bg-white rounded-lg px-4 py-2 border border-gray-100">
                                    <span class="text-gray-700">
                                        {{ $item->product->name }} × {{ $item->quantity }}
                                    </span>
                                    <span class="font-semibold text-[#076807]">
                                        ₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Delivery Address --}}
                        @if ($order->address)
                            <h4 class="text-sm font-semibold text-[#076807] mb-1">Delivery Address</h4>
                            <p class="text-sm text-gray-500 mb-4">
                                {{ $order->address->name }}, {{ $order->address->address }},
                                {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pin }}
                            </p>
                        @endif

                        {{-- Cancellation --}}
                        @if ($order->cancellation_requested)
                            <div class="text-sm px-3 py-2 rounded-lg
                                {{ $order->cancellation_status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                {{ $order->cancellation_status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $order->cancellation_status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}">
                                Cancellation: {{ ucfirst($order->cancellation_status) }}
                            </div>
                        @elseif (in_array($order->status, ['pending', 'shipped']))
                            <form method="POST" action="{{ route('customer.orders.cancel', $order) }}">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Request cancellation for this order?')"
                                        class="text-sm text-red-600 hover:underline">
                                    Request Cancellation
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            @empty
                <div class="bg-white shadow rounded-lg p-12 text-center border border-gray-100">
                    <p class="text-gray-400">No orders yet.</p>
                    <a href="{{ route('products.index') }}" class="text-[#38b000] hover:underline ml-1 text-sm">Start shopping</a>
                </div>
            @endforelse

        </div>
    </div>

    <script>
        function toggleOrder(id) {
            const details = document.getElementById('order-' + id);
            const arrow   = document.getElementById('arrow-' + id);
            details.classList.toggle('hidden');
            arrow.textContent = details.classList.contains('hidden') ? '▼' : '▲';
        }

        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const first = document.querySelector('[id^="order-"]');
                if (first) toggleOrder(first.id.replace('order-', ''));
            });
        @endif
    </script>
</x-app-layout>
