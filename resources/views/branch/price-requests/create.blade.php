<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5] py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('branch.price-requests.index') }}"
                   class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1 mb-2">
                    ← Back to Requests
                </a>
                <h1 class="text-2xl font-bold text-[#076807]">New Price Change Request</h1>
                <p class="text-sm text-gray-500 mt-1">Submit a request to change a product's price. Admin will review it.</p>
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

            <form method="POST" action="{{ route('branch.price-requests.store') }}">
                @csrf

                <div class="grid grid-cols-3 gap-6">

                    {{-- LEFT --}}
                    <div class="col-span-2 space-y-5">

                        {{-- Product & Price --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Product & Price</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Product <span class="text-red-500">*</span>
                                    </label>
                                    <select name="product_id" required
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                        <option value="">— Select a product —</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                                (Current: ₹{{ number_format($product->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Requested Price (₹) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                        <input type="number" name="requested_price"
                                               value="{{ old('requested_price') }}"
                                               step="0.01" min="0" required
                                               placeholder="0.00"
                                               class="w-full border border-gray-200 rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9]">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Reason --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-5">Reason</h2>
                            <textarea name="reason" rows="5" required
                                      placeholder="Explain why this price change is needed..."
                                      class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807] bg-[#f9fbf9] resize-none">{{ old('reason') }}</textarea>
                            <p class="text-xs text-gray-400 mt-2">Max 1000 characters. Be specific — admin will review this before approving.</p>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-span-1 space-y-5">

                        {{-- Info card --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Note</h2>
                            <div class="space-y-3 text-xs text-gray-500 leading-relaxed">
                                <p>📋 You can only have one pending request per product at a time.</p>
                                <p>✅ Once approved, the product price will be updated globally.</p>
                                <p>❌ Rejected requests can be resubmitted with a new reason.</p>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="bg-[#076807] rounded-xl p-6 text-center shadow">
                            <p class="text-green-200 text-xs mb-4">Request will be sent to admin for review</p>
                            <button type="submit"
                                    class="w-full bg-white hover:bg-[#E9EFE5] text-[#076807] font-bold py-3 rounded-full text-sm transition shadow">
                                Submit Request
                            </button>
                            <a href="{{ route('branch.price-requests.index') }}"
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
