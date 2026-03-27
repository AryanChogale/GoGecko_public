<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('admin.branches.index') }}"
                       class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                        ← Back to Branches
                    </a>
                    <h1 class="text-2xl font-bold text-[#076807]">Edit Branch</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $branch->name }}{{ $branch->city ? ' - ' . $branch->city : '' }}</p>
                </div>
                <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Delete {{ addslashes($branch->name) }} and its login account?')"
                            class="text-sm text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-4 py-2 rounded-lg transition">
                        Delete Branch
                    </button>
                </form>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.branches.update', $branch) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Branch Info --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Branch Info</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Branch Name <span class="text-red-500">*</span>
                                        <span class="text-xs text-gray-400 font-normal">(state name used for order routing)</span>
                                    </label>
                                    <input type="text" name="name"
                                           value="{{ old('name', $branch->name) }}" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" name="city"
                                               value="{{ old('city', $branch->city) }}"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="phone"
                                               value="{{ old('phone', $branch->phone) }}"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea name="address" rows="2"
                                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('address', $branch->address) }}</textarea>
                                </div>

                                {{-- Geo status --}}
                                <div class="flex items-center gap-2 pt-1">
                                    @if ($branch->latitude && $branch->longitude)
                                        <span class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-700 px-3 py-1.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Geocoded - {{ $branch->latitude }}, {{ $branch->longitude }}
                                        </span>
                                        <span class="text-xs text-gray-400">Will re-geocode if city or name changes</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                            No coordinates - will geocode on save
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Login Credentials --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Login Credentials</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email"
                                           value="{{ old('email', $branch->user?->email) }}" required
                                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            New Password
                                            <span class="text-gray-400 text-xs font-normal">(leave blank to keep)</span>
                                        </label>
                                        <input type="password" name="password"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm Password
                                        </label>
                                        <input type="password" name="password_confirmation"
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Stats card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Overview</h2>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Total Orders</span>
                                    <span class="font-bold text-[#076807]">{{ $branch->orders()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Pending Orders</span>
                                    <span class="font-bold text-yellow-600">{{ $branch->orders()->where('status', 'pending')->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Delivered</span>
                                    <span class="font-bold text-green-600">{{ $branch->orders()->where('status', 'delivered')->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Price Requests</span>
                                    <span class="font-bold text-gray-700">{{ $branch->priceChangeRequests()->count() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Save card --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">City changes will trigger re-geocoding</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.branches.index') }}"
                               class="block text-green-300 hover:text-white text-xs mt-3 transition">
                                Cancel
                            </a>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
