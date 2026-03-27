<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - GoGecko</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#E9EFE5] min-h-screen">

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    {{-- Left --}}
    <div class="hidden md:flex flex-col justify-center gap-16 bg-[#076807] px-14 py-12">
        <div>
            <h1 class="text-5xl font-bold text-white leading-tight mb-4">Verify<br>Your Email.</h1>
            <p class="text-green-300 text-base leading-relaxed max-w-xs">
                One last step - verify your email to start using your GoGecko account.
            </p>
        </div>
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center">📧</span>
                Check your inbox
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center">🔗</span>
                Click the verification link
            </div>
            <div class="flex items-center gap-3 text-green-200 text-sm">
                <span class="w-8 h-8 rounded-full bg-white bg-opacity-10 flex items-center justify-center">✅</span>
                Start ordering on GoGecko
            </div>
        </div>
    </div>

    {{-- Right --}}
    <div class="flex flex-col justify-center px-8 sm:px-16 py-12">
        <div class="max-w-md w-full mx-auto">

            <div class="flex justify-end mb-8">
                <a href="/"><img src="{{ asset('storage/logo/logo.png') }}" alt="GoGecko" class="h-10"></a>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-1">Check Your Email</h2>
            <p class="text-sm text-gray-500 mb-8">
                Thanks for signing up! Please verify your email address by clicking the link we sent you.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-[#076807] hover:bg-green-900 text-white font-semibold py-3 rounded-xl transition shadow-md text-sm">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full border border-gray-300 text-gray-600 hover:border-red-400 hover:text-red-500 font-medium py-3 rounded-xl transition text-sm">
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
</body>
</html>
