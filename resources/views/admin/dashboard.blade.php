<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#076807]">Admin Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}</p>
            </div>

            @php
                $totalOrders     = \App\Models\Order::count();
                $pendingOrders   = \App\Models\Order::where('status', 'pending')->count();
                $deliveredOrders = \App\Models\Order::where('status', 'delivered')->count();
                $totalRevenue    = \App\Models\Order::where('status', 'delivered')->sum('total_amount');
                $pendingRequests = \App\Models\PriceChangeRequest::where('status', 'pending')->count();
                $pendingCancels  = \App\Models\Order::where('cancellation_status', 'pending')->count();
                $totalProducts   = \App\Models\Product::count();
                $totalBranches   = \App\Models\Branch::count();
            @endphp

            {{-- Stats grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-[#076807]">{{ $totalOrders }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $pendingOrders }} pending</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Revenue</p>
                    <p class="text-3xl font-bold text-[#076807]">₹{{ number_format($totalRevenue, 0) }}</p>
                    <p class="text-xs text-gray-400 mt-1">from {{ $deliveredOrders }} delivered</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Products</p>
                    <p class="text-3xl font-bold text-[#076807]">{{ $totalProducts }}</p>
                    <p class="text-xs text-gray-400 mt-1">across all categories</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Branches</p>
                    <p class="text-3xl font-bold text-[#076807]">{{ $totalBranches }}</p>
                    <p class="text-xs text-gray-400 mt-1">active locations</p>
                </div>

            </div>

            {{-- Attention needed + Quick links --}}
            <div class="grid grid-cols-3 gap-6 mb-8">

                {{-- Needs attention --}}
                <div class="col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Needs Attention</h2>
                    <div class="space-y-3">

                        <a href="{{ route('admin.price-requests.index') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $pendingRequests > 0 ? 'bg-yellow-50 hover:bg-yellow-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">💰</span>
                                <span class="text-sm font-medium text-gray-700">Price Requests</span>
                            </div>
                            <span class="text-sm font-bold {{ $pendingRequests > 0 ? 'text-yellow-600' : 'text-gray-400' }}">
                                {{ $pendingRequests }}
                            </span>
                        </a>

                        <a href="{{ route('admin.orders') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $pendingCancels > 0 ? 'bg-red-50 hover:bg-red-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">❌</span>
                                <span class="text-sm font-medium text-gray-700">Cancellations</span>
                            </div>
                            <span class="text-sm font-bold {{ $pendingCancels > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                {{ $pendingCancels }}
                            </span>
                        </a>

                        <a href="{{ route('admin.orders') }}"
                           class="flex items-center justify-between p-3 rounded-lg {{ $pendingOrders > 0 ? 'bg-orange-50 hover:bg-orange-100' : 'bg-gray-50 hover:bg-gray-100' }} transition">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">📦</span>
                                <span class="text-sm font-medium text-gray-700">Pending Orders</span>
                            </div>
                            <span class="text-sm font-bold {{ $pendingOrders > 0 ? 'text-orange-600' : 'text-gray-400' }}">
                                {{ $pendingOrders }}
                            </span>
                        </a>

                    </div>
                </div>

                {{-- Quick links --}}
                <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Quick Links</h2>
                    <div class="grid grid-cols-3 gap-3">

                        <a href="{{ route('admin.products.index') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">📦</span>
                            <span class="text-xs font-medium text-[#076807]">Products</span>
                        </a>

                        <a href="{{ route('admin.branches.index') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">🏢</span>
                            <span class="text-xs font-medium text-[#076807]">Branches</span>
                        </a>

                        <a href="{{ route('admin.orders') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">🛒</span>
                            <span class="text-xs font-medium text-[#076807]">Orders</span>
                        </a>

                        <a href="{{ route('admin.blogs.index') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">📝</span>
                            <span class="text-xs font-medium text-[#076807]">Blog Posts</span>
                        </a>

                        <a href="{{ route('admin.price-requests.index') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">💰</span>
                            <span class="text-xs font-medium text-[#076807]">Price Requests</span>
                        </a>

                        <a href="{{ route('admin.contact') }}"
                           class="flex flex-col items-center justify-center gap-2 p-4 bg-[#E9EFE5] hover:bg-green-100 rounded-xl transition text-center">
                            <span class="text-2xl">📬</span>
                            <span class="text-xs font-medium text-[#076807]">Contact</span>
                        </a>

                    </div>
                </div>

            </div>

            {{-- Recent orders --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Recent Orders</h2>
                    <a href="{{ route('admin.orders') }}"
                       class="text-xs text-[#076807] hover:underline">View all →</a>
                </div>

                @php
                    $recentOrders = \App\Models\Order::with(['customer', 'branch'])
                        ->latest()->take(5)->get();
                @endphp

                @if ($recentOrders->isEmpty())
                    <p class="text-sm text-gray-400 text-center py-6">No orders yet.</p>
                @else
                    <div class="space-y-2">
                        @foreach ($recentOrders as $order)
                            <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-[#076807] text-sm">#{{ $order->id }}</span>
                                    <span class="text-sm text-gray-700">{{ $order->customer->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $order->branch->name }}</span>
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
