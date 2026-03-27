<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            @php
                $branchId        = auth()->user()->branch_id;
                $totalOrders     = \App\Models\Order::where('branch_id', $branchId)->count();
                $pendingOrders   = \App\Models\Order::where('branch_id', $branchId)->where('status', 'pending')->count();
                $deliveredOrders = \App\Models\Order::where('branch_id', $branchId)->where('status', 'delivered')->count();
                $pendingCancels  = \App\Models\Order::where('branch_id', $branchId)->where('cancellation_status', 'pending')->count();
                $myRequests      = \App\Models\PriceChangeRequest::where('branch_id', $branchId)->where('status', 'pending')->count();
                $branch          = auth()->user()->branch;
            @endphp

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#076807]">Branch Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Welcome back, {{ auth()->user()->name }}
                    @if ($branch)
                        - {{ $branch->name }}{{ $branch->city ? ', ' . $branch->city : '' }}
                    @endif
                </p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-[#076807]">{{ $totalOrders }}</p>
                    <p class="text-xs text-gray-400 mt-1">all time</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Pending</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $pendingOrders }}</p>
                    <p class="text-xs text-gray-400 mt-1">need action</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Delivered</p>
                    <p class="text-3xl font-bold text-[#076807]">{{ $deliveredOrders }}</p>
                    <p class="text-xs text-gray-400 mt-1">completed</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Cancellations</p>
                    <p class="text-3xl font-bold text-red-500">{{ $pendingCancels }}</p>
                    <p class="text-xs text-gray-400 mt-1">awaiting review</p>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-6 mb-8">

                {{-- Needs attention --}}
                <div class="col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Needs Attention</h2>
                    <div class="space-y-3">

                        <a href="{{ route('branch.orders') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $pendingOrders > 0 ? 'bg-yellow-50 hover:bg-yellow-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">📦</span>
                                <span class="text-sm font-medium text-gray-700">Pending Orders</span>
                            </div>
                            <span class="text-sm font-bold {{ $pendingOrders > 0 ? 'text-yellow-600' : 'text-gray-400' }}">
                                {{ $pendingOrders }}
                            </span>
                        </a>

                        <a href="{{ route('branch.orders') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $pendingCancels > 0 ? 'bg-red-50 hover:bg-red-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">❌</span>
                                <span class="text-sm font-medium text-gray-700">Cancellations</span>
                            </div>
                            <span class="text-sm font-bold {{ $pendingCancels > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                {{ $pendingCancels }}
                            </span>
                        </a>

                        <a href="{{ route('branch.price-requests.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $myRequests > 0 ? 'bg-blue-50 hover:bg-blue-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">💰</span>
                                <span class="text-sm font-medium text-gray-700">My Requests</span>
                            </div>
                            <span class="text-sm font-bold {{ $myRequests > 0 ? 'text-blue-600' : 'text-gray-400' }}">
                                {{ $myRequests }}
                            </span>
                        </a>

                    </div>
                </div>

                {{-- Quick links --}}
                <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Quick Links</h2>
                    <div class="grid grid-cols-2 gap-3">

                        <a href="{{ route('branch.orders') }}"
                           class="flex items-center gap-3 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition">
                            <span class="text-2xl">🛒</span>
                            <div>
                                <p class="text-sm font-bold text-[#076807]">Orders</p>
                                <p class="text-xs text-gray-500">View and manage orders</p>
                            </div>
                        </a>

                        <a href="{{ route('branch.price-requests.index') }}"
                           class="flex items-center gap-3 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition">
                            <span class="text-2xl">💰</span>
                            <div>
                                <p class="text-sm font-bold text-[#076807]">Price Requests</p>
                                <p class="text-xs text-gray-500">Submit and track requests</p>
                            </div>
                        </a>

                        <a href="{{ route('branch.price-requests.create') }}"
                           class="flex items-center gap-3 p-4 bg-[#076807] hover:bg-green-900 rounded-xl transition">
                            <span class="text-2xl">➕</span>
                            <div>
                                <p class="text-sm font-bold text-white">New Price Request</p>
                                <p class="text-xs text-green-200">Request a price change</p>
                            </div>
                        </a>

                        <a href="/products"
                           class="flex items-center gap-3 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition">
                            <span class="text-2xl">📦</span>
                            <div>
                                <p class="text-sm font-bold text-[#076807]">Browse Products</p>
                                <p class="text-xs text-gray-500">View all products</p>
                            </div>
                        </a>

                    </div>
                </div>

            </div>

            {{-- Recent orders --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Recent Orders</h2>
                    <a href="{{ route('branch.orders') }}"
                       class="text-xs text-[#076807] hover:underline">View all →</a>
                </div>

                @php
                    $recentOrders = \App\Models\Order::with(['customer'])
                        ->where('branch_id', $branchId)
                        ->latest()->take(5)->get();
                @endphp

                @if ($recentOrders->isEmpty())
                    <p class="text-sm text-gray-400 text-center py-6">No orders assigned yet.</p>
                @else
                    <div class="space-y-2">
                        @foreach ($recentOrders as $order)
                            <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-[#076807] text-sm">#{{ $order->id }}</span>
                                    <span class="text-sm text-gray-700">{{ $order->customer->name }}</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-700">₹{{ number_format($order->total_amount, 2) }}</span>
                                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                        {{ $order->status === 'delivered'        ? 'bg-green-100 text-green-700'   : '' }}
                                        {{ $order->status === 'pending'          ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status === 'shipped'          ? 'bg-blue-100 text-blue-700'     : '' }}
                                        {{ $order->status === 'out_for_delivery' ? 'bg-purple-100 text-purple-700' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-app-layout>
