<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - GoGecko</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Rammetto+One&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#E9EFE5] min-h-screen">

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    {{-- Left - branding panel --}}
    <div class="hidden md:flex flex-col justify-center gap-16 bg-[#076807] px-14 py-12">

        <div>
            <h1 class="text-5xl font-bold text-white leading-tight mb-4">
                Welcome<br>back.
            </h1>
            <p class="text-green-300 text-base leading-relaxed max-w-xs">
                Log in to manage your orders, track deliveries, and access your GoGecko account.
            </p>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">📦</span>
                Hassle-free bulk procurement
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">🚚</span>
                Fast delivery to your branch
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center text-base">🌿</span>
                Global standard products
            </div>
        </div>

    </div>

    {{-- Right - form panel --}}
    <div class="flex flex-col justify-center px-8 sm:px-16 py-12">

        <div class="max-w-md w-full mx-auto">

            {{-- Mobile logo --}}
            <div class="flex justify-end mb-8">
                <a href="/"><img src="{{ asset('storage/logo/logo-text.png') }}" alt="GoGecko" class="h-12"></a>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-1">Sign in</h2>
            <p class="text-sm text-gray-500 mb-8">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#076807] font-semibold hover:underline">Register</a>
            </p>

            {{-- Session status --}}
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-[#076807] hover:underline">Forgot password?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#076807] transition">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="rounded border-gray-300 accent-[#076807]">
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>

                <button type="submit"
                        class="w-full bg-[#076807] hover:bg-green-900 text-white font-semibold py-3 rounded-xl transition shadow-md text-sm">
                    Sign In
                </button>

            </form>

        </div>
    </div>

</div>

</body>
</html>
