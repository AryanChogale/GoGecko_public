<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#076807]">Orders</h1>
                <p class="text-sm text-gray-500 mt-1">All customer orders across all branches</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($orders as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4 overflow-hidden">

                    {{-- Order Header --}}
                    <div class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-[#f7fdf7] transition"
                         onclick="toggleOrder({{ $order->id }})">

                        <div class="flex items-center gap-8 flex-wrap">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Order</p>
                                <p class="font-bold text-[#076807]">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Customer</p>
                                <p class="text-sm font-medium text-gray-800">{{ $order->customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Branch</p>
                                <p class="text-sm text-gray-600">{{ $order->branch->name }}{{ $order->branch->city ? ' - ' . $order->branch->city : '' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Date</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Total</p>
                                <p class="text-sm font-bold text-[#076807]">₹{{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @if ($order->cancellation_requested && $order->cancellation_status === 'pending')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-red-100 text-red-600 font-medium">
                                    Cancel Requested
                                </span>
                            @endif
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                {{ $order->status === 'delivered'        ? 'bg-green-100 text-green-700'  : '' }}
                                {{ $order->status === 'pending'          ? 'bg-yellow-100 text-yellow-700': '' }}
                                {{ $order->status === 'shipped'          ? 'bg-blue-100 text-blue-700'   : '' }}
                                {{ $order->status === 'out_for_delivery' ? 'bg-purple-100 text-purple-700': '' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            <span class="text-[#076807] text-sm" id="arrow-{{ $order->id }}">▼</span>
                        </div>

                    </div>

                    {{-- Order Details --}}
                    <div id="order-{{ $order->id }}" class="hidden border-t border-gray-100 bg-[#f7fdf7]">

                        <div class="grid grid-cols-3 divide-x divide-gray-100">

                            {{-- Items --}}
                            <div class="px-6 py-5">
                                <h4 class="text-xs font-bold text-[#076807] uppercase tracking-wide mb-3">Items</h4>
                                <div class="space-y-2">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">
                                                {{ $item->product->name }}
                                                <span class="text-gray-400">× {{ $item->quantity }}</span>
                                            </span>
                                            <span class="font-medium text-[#076807]">
                                                ₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="px-6 py-5">
                                <h4 class="text-xs font-bold text-[#076807] uppercase tracking-wide mb-3">Delivery Address</h4>
                                @if ($order->address)
                                    <p class="text-sm font-medium text-gray-800">{{ $order->address->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                                        {{ $order->address->address }},
                                        {{ $order->address->city }},
                                        {{ $order->address->state }} - {{ $order->address->pin }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2">📞 {{ $order->address->phone }}</p>
                                @else
                                    <p class="text-sm text-gray-400">No address on record.</p>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="px-6 py-5">
                                <h4 class="text-xs font-bold text-[#076807] uppercase tracking-wide mb-3">Actions</h4>

                                {{-- Status update --}}
                                @if ($order->status !== 'delivered' && $order->cancellation_status !== 'approved')
                                    <form method="POST"
                                          action="{{ route('admin.orders.updateStatus', $order) }}"
                                          class="flex items-center gap-2 mb-4">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-white">
                                            <option value="pending"          {{ $order->status === 'pending'          ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped"          {{ $order->status === 'shipped'          ? 'selected' : '' }}>Shipped</option>
                                            <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                            <option value="delivered"        {{ $order->status === 'delivered'        ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                        <button type="submit"
                                                class="bg-[#076807] hover:bg-green-900 text-white text-xs font-medium px-3 py-2 rounded-lg transition">
                                            Update
                                        </button>
                                    </form>
                                @elseif ($order->status === 'delivered')
                                    <p class="text-xs text-green-600 font-medium mb-4">✓ Order delivered</p>
                                @elseif ($order->cancellation_status === 'approved')
                                    <p class="text-xs text-red-500 font-medium mb-4">✗ Cancellation approved</p>
                                @endif

                                {{-- Cancellation --}}
                                @if ($order->cancellation_requested && $order->cancellation_status === 'pending')
                                    <div class="bg-red-50 rounded-lg p-3">
                                        <p class="text-xs text-red-600 font-medium mb-2">Customer requested cancellation</p>
                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('admin.orders.approveCancellation', $order) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.orders.rejectCancellation', $order) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @elseif ($order->cancellation_requested)
                                    <p class="text-xs text-gray-400">
                                        Cancellation: {{ ucfirst($order->cancellation_status) }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-16 text-center border border-gray-100">
                    <p class="text-gray-400">No orders yet.</p>
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
    </script>

</x-app-layout>
