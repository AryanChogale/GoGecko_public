<x-app-layout>

    <div class="min-h-screen bg-[#E9EFE5]">

        {{-- Hero --}}
        <div class="bg-[#076807] py-14 text-center">
            <h1 class="text-4xl font-bold text-white mb-2">Contact Us</h1>
            <p class="text-green-200 text-sm">Feel free to connect with us for any requirement</p>
        </div>

        {{-- Main --}}
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

                {{-- Left — info + social --}}
                <div>
                    <div class="space-y-3 text-gray-700 text-sm mb-10">
                        <p>
                            <span class="font-bold">Address:</span>
                            41/27, Main Khandsa Road, Near Honda Showroom, Gurgaon, Haryana - 122001
                        </p>
                        <p>
                            <span class="font-bold">Phone:</span>
                            <a href="tel:+917042790775" class="hover:text-[#076807] transition">+91-7042790775</a>
                        </p>
                        <p>
                            <span class="font-bold">Email:</span>
                            <a href="mailto:helpdesk@gogecko.in" class="hover:text-[#076807] transition">helpdesk@gogecko.in</a>
                        </p>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-5">Follow Us</h3>

                    <div class="flex items-center gap-3">
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/gogecko" class="bg-[#076807] hover:bg-[#38b000] text-white rounded-lg p-3 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="https://www.linkedin.com/in/gogecko/" class="bg-[#076807] hover:bg-[#38b000] text-white rounded-lg p-3 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14m-.5 15.5v-5.3a3.26 3.26 0 00-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 011.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 001.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 00-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                        </a>
                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/_gogecko_/" class="bg-[#076807] hover:bg-[#38b000] text-white rounded-lg p-3 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        {{-- Twitter/X --}}
                        <a href="https://twitter.com/gogecko" class="bg-[#076807] hover:bg-[#38b000] text-white rounded-lg p-3 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        {{-- WhatsApp --}}
                        <a href="https://api.whatsapp.com/send?phone=917042709775&text=%20Hi,%20I%20got%20your%20number%20from%20GoGecko%20Website." target="_blank" class="bg-[#076807] hover:bg-[#38b000] text-white rounded-lg p-3 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Right — form --}}
                <div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                        @csrf

                        <input type="text" name="full_name" required
                               value="{{ old('full_name') }}"
                               placeholder="Full Name"
                               class="w-full bg-white border-0 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#076807] shadow-sm">

                        <input type="email" name="email" required
                               value="{{ old('email') }}"
                               placeholder="Email ID"
                               class="w-full bg-white border-0 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#076807] shadow-sm">

                        <input type="text" name="phone" required maxlength="10"
                               value="{{ old('phone') }}"
                               placeholder="Phone Number"
                               class="w-full bg-white border-0 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#076807] shadow-sm">

                        <textarea name="message" required rows="6"
                                  placeholder="Your Message"
                                  class="w-full bg-white border-0 rounded-lg px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#076807] shadow-sm resize-y">{{ old('message') }}</textarea>

                        <button type="submit"
                                class="w-full bg-[#38b000] hover:bg-[#076807] text-white font-semibold py-3 rounded-full text-sm transition shadow-md">
                            Submit
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
