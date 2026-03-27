<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - GoGecko</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#E9EFE5] min-h-screen">

    <div class="min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('cart.index') }}" class="text-sm text-gray-500 hover:text-[#076807] transition inline-flex items-center gap-1">
                    ← Back to Cart
                </a>
                <a href="/">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="GoGecko" class="h-10">
                </a>
            </div>

            <h1 class="text-2xl font-bold text-[#076807] mb-6">Complete Your Order</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:items-stretch">

                {{-- Left - Order Summary --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Order Summary</h2>
                    </div>
                    <div class="divide-y divide-gray-100 flex-1">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center px-6 py-3 text-sm">
                                <span class="text-gray-700">
                                    {{ $item->product->name }}
                                    <span class="text-gray-400">× {{ $item->quantity }}</span>
                                </span>
                                <span class="font-medium text-gray-900">₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-auto">
                        <div class="px-6 py-3 flex justify-between text-sm border-t border-gray-100">
                            <span class="text-gray-500">Branch</span>
                            <span class="font-medium text-gray-700">{{ $order->branch->name }} — {{ $order->branch->city }}</span>
                        </div>
                        <div class="px-6 py-4 flex justify-between border-t-2 border-[#076807]">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-[#076807] text-lg">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right - Payment --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
    <div class="px-6 py-5 border-b border-gray-100">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Card Details</h2>
    </div>
    <div class="px-6 py-6 flex flex-col flex-1">

        {{-- Card input stays at top --}}
        <div class="flex-1">
            <div id="card-container"></div>
        </div>

        {{-- Everything else sticks to bottom --}}
        <div class="space-y-3 mt-auto pt-4">

            @if(config('square.environment') === 'sandbox')
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-xs text-green-700">
                    🧪 <strong>Sandbox mode</strong> - Test card:
                    <code class="bg-green-100 px-1 rounded font-mono">4111 1111 1111 1111</code>
                    · Any future expiry · Any CVV · Any ZIP
                </div>
            @endif

            <div id="payment-error" class="hidden p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <span class="text-red-500 text-lg leading-none">✕</span>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Payment Failed</p>
                        <p id="payment-error-msg" class="text-sm text-red-600 mt-0.5"></p>
                        <p class="text-xs text-red-400 mt-1">Please check your card details and try again.</p>
                    </div>
                </div>
            </div>

            <div id="payment-success" class="hidden p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <span class="text-[#076807] text-lg leading-none">✓</span>
                    <div>
                        <p class="text-sm font-semibold text-[#076807]">Payment Successful!</p>
                        <p id="payment-success-msg" class="text-sm text-green-700 mt-0.5"></p>
                        <p class="text-xs text-green-500 mt-1">Redirecting you to your orders...</p>
                    </div>
                </div>
            </div>

            <button id="pay-btn"
                    class="w-full bg-[#076807] hover:bg-green-900 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 rounded-full text-sm transition shadow-md flex items-center justify-center gap-2">
                <span id="pay-btn-text">Pay ₹{{ number_format($order->total_amount, 2) }}</span>
                <svg id="pay-spinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
            </button>

            <p class="text-xs text-gray-400 text-center">🔒 Secured by Square</p>

        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    <script>
        const SQUARE_APP_ID      = "{{ $appId }}";
        const SQUARE_LOCATION_ID = "{{ $locationId }}";
        const PROCESS_URL        = "{{ route('payment.process', $order) }}";
        const CSRF_TOKEN         = document.querySelector('meta[name="csrf-token"]').content;

        async function initSquare() {
            if (!window.Square) {
                showError('Square SDK failed to load. Please refresh the page.');
                return;
            }

            const payments = Square.payments(SQUARE_APP_ID, SQUARE_LOCATION_ID);
            const card = await payments.card({
                style: {
                    '.input-container.is-focus': { borderColor: '#076807' },
                    '.input-container.is-error': { borderColor: '#dc2626' },
                }
            });
            await card.attach('#card-container');

            document.getElementById('pay-btn').addEventListener('click', async () => {
                setLoading(true);
                clearMessages();

                try {
                    const result = await card.tokenize();

                    if (result.status !== 'OK') {
                        const msg = result.errors?.map(e => e.message).join(', ') || 'Card tokenization failed.';
                        showError(msg);
                        setLoading(false);
                        return;
                    }

                    const response = await fetch(PROCESS_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                        },
                        body: JSON.stringify({ source_id: result.token }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        showSuccess(data.message);
                        setTimeout(() => { window.location.href = data.redirect; }, 2000);
                    } else {
                        showError(data.error || 'Payment failed. Please try again.');
                        setLoading(false);
                    }

                } catch (err) {
                    showError('Something went wrong. Please try again.');
                    setLoading(false);
                }
            });
        }

        function setLoading(loading) {
            const btn = document.getElementById('pay-btn');
            btn.disabled = loading;
            document.getElementById('pay-spinner').classList.toggle('hidden', !loading);
            document.getElementById('pay-btn-text').textContent = loading
                ? 'Processing...'
                : 'Pay ₹{{ number_format($order->total_amount, 2) }}';
        }

        function showError(msg) {
            document.getElementById('payment-error-msg').textContent = msg;
            document.getElementById('payment-error').classList.remove('hidden');
            document.getElementById('payment-success').classList.add('hidden');
        }

        function showSuccess(msg) {
            document.getElementById('payment-success-msg').textContent = msg;
            document.getElementById('payment-success').classList.remove('hidden');
            document.getElementById('payment-error').classList.add('hidden');
            document.getElementById('pay-btn').classList.add('hidden');
        }

        function clearMessages() {
            document.getElementById('payment-error').classList.add('hidden');
            document.getElementById('payment-success').classList.add('hidden');
        }

        initSquare();
    </script>

</body>
</html>
