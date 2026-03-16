<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — GoGecko</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#E9EFE5] min-h-screen">

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    {{-- Left — branding panel --}}
    <div class="hidden md:flex flex-col justify-center gap-16 bg-[#076807] px-14 py-12">

        <div>
            <h1 class="text-5xl font-bold text-white leading-tight mb-4">
                Join<br>GoGecko.
            </h1>
            <p class="text-green-300 text-base leading-relaxed max-w-xs">
                Create your account and start procuring smarter — faster delivery, better products, all in one place.
            </p>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">🏨</span>
                Built for HORECA & Institutions
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">⚡</span>
                Simple, dynamic, adaptable
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">📍</span>
                Nearest branch assigned automatically
            </div>
        </div>

    </div>

    {{-- Right — form panel --}}
    <div class="flex flex-col justify-center px-8 sm:px-16 py-12 overflow-y-auto">

        <div class="max-w-md w-full mx-auto">

            {{-- Mobile logo --}}
            <div class="flex justify-end mb-8">
                <a href="/"><img src="{{ asset('storage/logo/logo-text.png') }}" alt="GoGecko" class="h-12"></a>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-1">Create account</h2>
            <p class="text-sm text-gray-500 mb-8">
                Already registered?
                <a href="{{ route('login') }}" class="text-[#076807] font-semibold hover:underline">Sign in</a>
            </p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                {{-- State --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <select name="state" id="state" required onchange="onStateChange(this.value)"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                        <option value="">Select your state...</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}" {{ old('state') === $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- City --}}
                <div id="city-wrapper" class="{{ old('state') ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <div class="relative">
                        <input type="text" id="city-input"
                               placeholder="Type your city..."
                               autocomplete="off"
                               value="{{ old('city') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                        <input type="hidden" name="city" id="city-hidden" value="{{ old('city') }}">
                        <ul id="city-suggestions"
                            class="absolute z-50 w-full bg-white border border-gray-200 rounded-xl shadow-lg mt-1 hidden max-h-48 overflow-y-auto">
                        </ul>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                <button type="submit"
                        class="w-full bg-[#076807] hover:bg-green-900 text-white font-semibold py-3 rounded-xl transition shadow-md text-sm">
                    Create Account
                </button>

            </form>

        </div>
    </div>

</div>

<script>
    let citiesData = null;
    let selectedState = '{{ old('state') }}';

    async function loadCitiesData() {
        if (citiesData) return citiesData;
        const res = await fetch('/data/indian_cities.json');
        citiesData = await res.json();
        return citiesData;
    }

    function onStateChange(state) {
        selectedState = state;
        const wrapper     = document.getElementById('city-wrapper');
        const input       = document.getElementById('city-input');
        const hidden      = document.getElementById('city-hidden');
        const suggestions = document.getElementById('city-suggestions');
        input.value = '';
        hidden.value = '';
        suggestions.innerHTML = '';
        suggestions.classList.add('hidden');
        if (!state) { wrapper.classList.add('hidden'); return; }
        wrapper.classList.remove('hidden');
        loadCitiesData();
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (selectedState) loadCitiesData();
        const input       = document.getElementById('city-input');
        const hidden      = document.getElementById('city-hidden');
        const suggestions = document.getElementById('city-suggestions');
        if (!input) return;

        input.addEventListener('input', async function () {
            const query = this.value.trim().toLowerCase();
            hidden.value = '';
            if (query.length < 1 || !selectedState) { suggestions.classList.add('hidden'); return; }
            const data        = await loadCitiesData();
            const stateCities = data[selectedState] || [];
            const matches     = stateCities.filter(c => c.city.toLowerCase().includes(query));
            suggestions.innerHTML = '';
            if (matches.length === 0) { suggestions.classList.add('hidden'); return; }
            matches.slice(0, 8).forEach(c => {
                const li = document.createElement('li');
                li.textContent = c.city;
                li.className = 'px-4 py-2 cursor-pointer hover:bg-[#E9EFE5] hover:text-[#076807] text-sm text-gray-700';
                li.addEventListener('click', () => {
                    input.value  = c.city;
                    hidden.value = c.city;
                    suggestions.classList.add('hidden');
                });
                suggestions.appendChild(li);
            });
            suggestions.classList.remove('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!input.contains(e.target)) suggestions.classList.add('hidden');
        });

        input.addEventListener('blur', function () {
            setTimeout(() => {
                if (!hidden.value && input.value) hidden.value = input.value;
            }, 200);
        });
    });
</script>

</body>
</html>
