<x-app-layout>
    <h1 class="text-4xl text-center text-gray-600 font-semibold mb-5 mt-10">Cart</h1>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('address_success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('address_success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            @if ($cartItems->isEmpty())
                <div class="bg-white shadow rounded-lg p-12 text-center text-gray-400">
                    Your cart is empty.
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline ml-1">Browse products</a>
                </div>
            @else
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-green-100">

                    {{-- Desktop table --}}
                    <table class="hidden md:table w-full text-sm text-left">
                        <thead class="bg-[#076807] text-green-100 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Quantity</th>
                                <th class="px-6 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($cartItems as $item)
                                @php $unitPrice = $item->product->priceForBranch($branchId ?? null); @endphp
                                <tr id="row-{{ $item->product->id }}">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        @if ($item->product->image_path)
                                            @php
                                                $imgSrc = Str::startsWith($item->product->image_path, 'http')
                                                    ? $item->product->image_path
                                                    : Storage::url($item->product->image_path);
                                            @endphp
                                            <img src="{{ $imgSrc }}" class="w-12 h-12 object-cover rounded">
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $item->product->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">₹{{ number_format($unitPrice, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-900">
                                        <div class="flex items-center gap-3">
                                            <button class="qty-minus rounded px-2 py-1 text-sm hover:bg-gray-100" data-product="{{ $item->product->id }}">-</button>
                                            <span id="qty-{{ $item->product->id }}">{{ $item->quantity }}</span>
                                            <button class="qty-plus rounded px-2 py-1 text-sm hover:bg-gray-100" data-product="{{ $item->product->id }}">+</button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-900">
                                        <span id="total-{{ $item->product->id }}">₹{{ number_format($unitPrice * $item->quantity, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-[#076807] uppercase text-xs">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-semibold text-green-100">Total</td>
                                <td id="cart-total" class="px-6 py-4 text-right font-bold text-white">
                                    ₹{{ number_format($cartItems->sum(fn($i) => $i->product->priceForBranch($branchId ?? null) * $i->quantity), 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Mobile cards --}}
                    <div class="md:hidden divide-y divide-gray-100">
                        @foreach ($cartItems as $item)
                            @php $unitPrice = $item->product->priceForBranch($branchId ?? null); @endphp
                            <div id="row-{{ $item->product->id }}" class="p-4 flex items-center gap-3">

                                {{-- Image --}}
                                @if ($item->product->image_path)
                                    @php
                                        $imgSrc = Str::startsWith($item->product->image_path, 'http')
                                            ? $item->product->image_path
                                            : Storage::url($item->product->image_path);
                                    @endphp
                                    <img src="{{ $imgSrc }}" class="w-14 h-14 object-cover rounded-lg shrink-0">
                                @endif

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm truncate">{{ $item->product->name }}</p>
                                    <p class="text-[#076807] font-semibold text-sm mt-0.5">₹{{ number_format($unitPrice, 2) }}</p>

                                    {{-- Qty controls --}}
                                    <div class="flex items-center gap-3 mt-2">
                                        <button class="qty-minus w-7 h-7 rounded-full bg-[#E9EFE5] text-[#076807] font-bold text-lg flex items-center justify-center hover:bg-[#076807] hover:text-white transition"
                                                data-product="{{ $item->product->id }}">−</button>
                                        <span id="qty-{{ $item->product->id }}" class="text-sm font-medium w-4 text-center">{{ $item->quantity }}</span>
                                        <button class="qty-plus w-7 h-7 rounded-full bg-[#E9EFE5] text-[#076807] font-bold text-lg flex items-center justify-center hover:bg-[#076807] hover:text-white transition"
                                                data-product="{{ $item->product->id }}">+</button>
                                    </div>
                                </div>

                                {{-- Total --}}
                                <div class="shrink-0 text-right">
                                    <span id="total-{{ $item->product->id }}" class="font-bold text-gray-900 text-sm">
                                        ₹{{ number_format($unitPrice * $item->quantity, 2) }}
                                    </span>
                                </div>

                            </div>
                        @endforeach

                        {{-- Mobile total --}}
                        <div class="bg-[#076807] px-4 py-3 flex items-center justify-between">
                            <span class="text-green-100 text-xs uppercase font-semibold">Total</span>
                            <span id="cart-total" class="text-white font-bold text-sm">
                                ₹{{ number_format($cartItems->sum(fn($i) => $i->product->priceForBranch($branchId ?? null) * $i->quantity), 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="px-4 md:px-6 py-4 border-t border-gray-100 flex justify-end">
                        @auth
                            @if (auth()->user()->isCustomer())
                                <button onclick="openAddressPanel()"
                                        class="border-2 bg-[#076807] hover:bg-white hover:text-[#076807] hover:border-[#076807] text-white font-medium px-6 py-2 rounded-lg text-sm transition">
                                    Select Address
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg text-sm transition">Login to Checkout</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="bg-[#076807] hover:bg-green-900 text-white font-medium px-6 py-2 rounded-lg text-sm transition">Login to Checkout</a>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ==================== ADDRESS SLIDE-OUT PANEL ==================== --}}
    @auth
    @if (auth()->user()->isCustomer())

    <div id="panel-backdrop" onclick="closeAddressPanel()"
         class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden"></div>

    <div id="address-panel"
        class="fixed top-0 right-0 h-full w-full max-w-md bg-[#E9EFE5] shadow-2xl z-50 transform translate-x-full transition-transform duration-300 overflow-y-auto border-l-4 border-[#076807]">
        <div class="p-6">

            <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-[#076807]">
                <h3 class="text-lg font-bold text-[#076807]">Select Delivery Address</h3>
                <button onclick="closeAddressPanel()" class="text-[#076807] hover:text-green-900 text-xl font-bold leading-none">✕</button>
            </div>

            <form method="POST" action="{{ route('checkout.selectAddress') }}" id="checkout-form">
                @csrf
                <input type="hidden" name="address_id" id="selected-address-id" value="">

                @if ($addresses->isNotEmpty())
                    <div class="space-y-3 mb-6">
                        @foreach ($addresses as $address)
                            <div class="address-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-[#076807] bg-white transition"
                                 id="address-card-{{ $address->id }}"
                                 onclick="selectAddress({{ $address->id }})">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-[#076807]">{{ $address->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pin }}
                                        </p>
                                        @if ($address->landmark)
                                            <p class="text-xs text-gray-400">Landmark: {{ $address->landmark }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400 mt-1">📞 {{ $address->phone }}</p>
                                    </div>
                                    <div class="shrink-0">
                                        <span id="check-{{ $address->id }}" class="hidden text-[#076807] font-bold text-lg">✓</span>
                                        <button type="button" onclick="removeAddress(event, {{ $address->id }})"
                                                class="text-xs text-red-500 hover:text-red-700 mt-1 block">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 mb-6">No saved addresses yet.</p>
                @endif

                <div class="mb-4">
                    <label class="flex items-start gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="sms_consent" value="1"
                               class="mt-0.5 rounded border-gray-300 accent-[#076807]"
                               {{ auth()->user()->customerProfile->sms_consent ? 'checked' : '' }}>
                        <span>I agree to receive order updates via WhatsApp and SMS on the provided phone numbers</span>
                    </label>
                </div>

                <button type="submit" id="place-order-btn"
                        class="hidden w-full bg-[#076807] hover:bg-green-900 text-white font-semibold py-3 rounded-lg text-sm transition shadow-md">
                    Place Order
                </button>
            </form>

            <button onclick="toggleNewAddressForm()" id="add-address-btn"
                    class="mt-4 w-full border-2 border-dashed border-[#076807] text-[#076807] hover:bg-[#076807] hover:text-white rounded-lg py-3 text-sm font-medium transition">
                + Add New Address
            </button>

            <div id="new-address-form" class="hidden mt-4">
                <form method="POST" action="{{ route('customer.addresses.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">State *</label>
                        <select name="state" id="addr-state-select" required onchange="onAddressStateChange(this.value)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                            <option value="">- Select State -</option>
                            @foreach ([
                                'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh',
                                'Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka',
                                'Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram',
                                'Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana',
                                'Tripura','Uttar Pradesh','Uttarakhand','West Bengal',
                                'Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu',
                                'Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'
                            ] as $state)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="addr-city-wrapper" class="{{ old('state') ? '' : 'hidden' }}">
                        <label class="block text-xs font-medium text-gray-700 mb-1">City *</label>
                        <input type="text" name="city" id="addr-city-input" required value="{{ old('city') }}"
                               placeholder="Type to search city..." autocomplete="off"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                        <ul id="addr-city-suggestions"
                            class="hidden border border-gray-200 shadow-lg max-h-40 overflow-y-auto text-sm z-10 relative"></ul>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Address *</label>
                        <textarea name="address" required rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">{{ old('address') }}</textarea>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1">PIN Code *</label>
                            <input type="text" name="pin" required maxlength="6" value="{{ old('pin') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Landmark</label>
                            <input type="text" name="landmark" value="{{ old('landmark') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" required value="{{ old('email', auth()->user()->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="text" name="phone" required maxlength="10" value="{{ old('phone') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">WhatsApp *</label>
                        <input type="text" name="whatsapp" required maxlength="10" value="{{ old('whatsapp') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#076807]">
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="submit"
                                class="flex-1 bg-[#076807] hover:bg-green-900 text-white font-medium py-2 rounded-lg text-sm transition">
                            Save Address
                        </button>
                        <button type="button" onclick="toggleNewAddressForm()"
                                class="text-sm text-gray-500 hover:text-gray-700 px-3">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @foreach ($addresses as $address)
        <form method="POST" action="{{ route('customer.addresses.destroy', $address) }}"
              id="remove-form-{{ $address->id }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    @endif
    @endauth

<script>
    function openAddressPanel() {
        document.getElementById('address-panel').classList.remove('translate-x-full');
        document.getElementById('panel-backdrop').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeAddressPanel() {
        document.getElementById('address-panel').classList.add('translate-x-full');
        document.getElementById('panel-backdrop').classList.add('hidden');
        document.body.style.overflow = '';
    }
    function toggleNewAddressForm() {
        document.getElementById('new-address-form').classList.toggle('hidden');
        document.getElementById('add-address-btn').classList.toggle('hidden');
    }

    let citiesData = null;
    async function loadCitiesData() {
        if (citiesData) return citiesData;
        const res = await fetch('/data/indian_cities.json');
        citiesData = await res.json();
        return citiesData;
    }
    function onAddressStateChange(state) {
        const wrapper     = document.getElementById('addr-city-wrapper');
        const input       = document.getElementById('addr-city-input');
        const suggestions = document.getElementById('addr-city-suggestions');
        input.value = '';
        suggestions.innerHTML = '';
        suggestions.classList.add('hidden');
        if (!state) { wrapper.classList.add('hidden'); return; }
        wrapper.classList.remove('hidden');
        loadCitiesData();
    }
    document.addEventListener('DOMContentLoaded', function () {
        const cityInput = document.getElementById('addr-city-input');
        if (!cityInput) return;
        cityInput.addEventListener('input', async function () {
            const query       = this.value.trim().toLowerCase();
            const state       = document.getElementById('addr-state-select').value;
            const suggestions = document.getElementById('addr-city-suggestions');
            if (query.length < 1 || !state) { suggestions.classList.add('hidden'); return; }
            const data        = await loadCitiesData();
            const stateCities = data[state] || [];
            const matches     = stateCities.filter(c => c.city.toLowerCase().includes(query));
            suggestions.innerHTML = '';
            if (matches.length === 0) { suggestions.classList.add('hidden'); return; }
            matches.forEach(c => {
                const li = document.createElement('li');
                li.textContent = c.city;
                li.className = 'px-3 py-2 cursor-pointer hover:bg-gray-100 text-gray-800';
                li.addEventListener('click', () => { cityInput.value = c.city; suggestions.classList.add('hidden'); });
                suggestions.appendChild(li);
            });
            suggestions.classList.remove('hidden');
        });
        document.addEventListener('click', function (e) {
            const suggestions = document.getElementById('addr-city-suggestions');
            if (suggestions && !cityInput.contains(e.target)) suggestions.classList.add('hidden');
        });
    });

    function selectAddress(id) {
        document.querySelectorAll('.address-card').forEach(card => {
            card.classList.remove('border-green-700', 'bg-green-50');
        });
        document.querySelectorAll('[id^="check-"]').forEach(el => el.classList.add('hidden'));
        document.getElementById('address-card-' + id).classList.add('border-green-700', 'bg-green-50');
        document.getElementById('check-' + id).classList.remove('hidden');
        document.getElementById('selected-address-id').value = id;
        document.getElementById('place-order-btn').classList.remove('hidden');
    }

    function removeAddress(event, id) {
        event.stopPropagation();
        if (confirm('Remove this address?')) document.getElementById('remove-form-' + id).submit();
    }

    // also i spent an entire hour on an error only to figure out that it was because HTML does not allow forms nested inside of forms bruhhhhhhhhhhhhhhhhhhhhhhhhh
    @if ($errors->any() || session('address_success'))
        document.addEventListener('DOMContentLoaded', openAddressPanel);
    @endif
</script>

<script>
document.querySelectorAll(".qty-plus").forEach(btn => {
    btn.addEventListener("click", () => updateQuantity(btn.dataset.product, 1));
});
document.querySelectorAll(".qty-minus").forEach(btn => {
    btn.addEventListener("click", () => updateQuantity(btn.dataset.product, -1));
});

function recalcCartTotal() {
    let total = 0;
    document.querySelectorAll("[id^='total-']").forEach(el => {
        const val = parseFloat(el.innerText.replace(/[^0-9.]/g, ''));
        if (!isNaN(val)) total += val;
    });
    document.getElementById("cart-total").innerText = "₹" + total.toFixed(2);
}

function updateQuantity(productId, change) {
    fetch("/cart/update", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, change: change })
    })
    .then(res => res.json())
    .then(data => {
        if (data.removed) {
            document.getElementById("row-" + productId)?.remove();
            data.cartTotal
                ? document.getElementById("cart-total").innerText = "₹" + data.cartTotal
                : recalcCartTotal();
            const cartCount = document.getElementById("cart-count");
            if (cartCount) cartCount.textContent = Math.max(0, parseInt(cartCount.textContent) - data.removedQty);
            return;
        }
        const cartCount = document.getElementById("cart-count");
        if (cartCount) cartCount.textContent = parseInt(cartCount.textContent) + change;
        document.getElementById("qty-" + productId).innerText = data.quantity;
        document.getElementById("total-" + productId).innerText = "₹" + data.total;
        data.cartTotal
            ? document.getElementById("cart-total").innerText = "₹" + data.cartTotal
            : recalcCartTotal();
    });
}
</script>

</x-app-layout>
