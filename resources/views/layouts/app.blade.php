<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#E9EFE5]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <div id="cart-toast"
                 class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-4 opacity-0 pointer-events-none transition duration-300">

                <span id="cart-toast-text">
                    Cart Updated Successfully.
                </span>

                <button id="cart-toast-close"
                        class="border border-white px-3 py-1 rounded hover:bg-white hover:text-green-600 transition">
                    OK
                </button>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
new Swiper(".clientSwiper", {
    slidesPerView: 5,
    spaceBetween: 40,
    loop: true,

    autoplay: {
        delay: 5000,
        disableOnInteraction: false
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    grabCursor: true,

    breakpoints: {
        320: { slidesPerView: 2 },
        640: { slidesPerView: 3 },
        1024: { slidesPerView: 5 }
    }
});
</script>

<script>
const counters = document.querySelectorAll('.counter');
let started = false;

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {

        if(entry.isIntersecting && !started){

            started = true;

            counters.forEach(counter => {

                const target = +counter.getAttribute('data-target');
                const duration = 1500;
                const stepTime = Math.abs(Math.floor(duration / target));
                let current = 0;

                const timer = setInterval(() => {

                    current += Math.ceil(target / 100);

                    if(current >= target){
                        counter.innerText = target + "+";
                        clearInterval(timer);
                    } else {
                        counter.innerText = current;
                    }

                }, 10);

            });

        }

    });
}, { threshold: 0.5 });

observer.observe(document.querySelector('#stats'));
</script>

<script>
new Swiper(".productSwiper", {

    slidesPerView: 3,
    spaceBetween: 30,

    loop: true,

    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },

    navigation: {
        nextEl: ".productSwiper .swiper-button-next",
        prevEl: ".productSwiper .swiper-button-prev",
    },

    grabCursor: true,

    breakpoints: {
        320: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
    }

});
</script>

<script>
new Swiper(".testimonialSwiper", {

    slidesPerView: 1,
    loop: true,

    autoplay: {
        delay: 5000,
        disableOnInteraction: false
    },

    navigation: {
        nextEl: ".testimonial-next",
        prevEl: ".testimonial-prev",
    },

    grabCursor: true

});
</script>

<script>

document.addEventListener("DOMContentLoaded", () => {

    const toast = document.getElementById("cart-toast")
    const toastText = document.getElementById("cart-toast-text")
    const toastClose = document.getElementById("cart-toast-close")

    function showToast(msg){

        toastText.innerText = msg

        toast.classList.remove("opacity-0","pointer-events-none")
        toast.classList.add("opacity-100")

        setTimeout(hideToast,3000)

    }

    function hideToast(){

        toast.classList.add("opacity-0","pointer-events-none")
        toast.classList.remove("opacity-100")

    }

    toastClose.addEventListener("click", hideToast)



    /* quantity buttons */

    document.querySelectorAll(".qty-plus").forEach(btn => {

        btn.addEventListener("click", () => {

            const input = btn.parentElement.querySelector(".qty-input")

            input.value = parseInt(input.value) + 1

        })

    })


    document.querySelectorAll(".qty-minus").forEach(btn => {

        btn.addEventListener("click", () => {

            const input = btn.parentElement.querySelector(".qty-input")

            if(input.value > 1){

                input.value = parseInt(input.value) - 1

            }

        })

    })



    /* AJAX cart */

    document.querySelectorAll(".add-to-cart-form").forEach(form => {

        form.addEventListener("submit", e => {

            e.preventDefault()

            const formData = new FormData(form)

            fetch(form.action, {

                method:"POST",

                headers:{
                    "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content,
                    "X-Requested-With":"XMLHttpRequest"
                },

                body:formData

            })
            .then(res => res.json())
            .then(data => {

                if(data.success){

                    showToast("Cart Updated Successfully.")

                    const input = form.querySelector(".qty-input")
                    input.value = 1

                    const cartCount = document.getElementById("cart-count")

                    if(cartCount){
                        cartCount.textContent = parseInt(cartCount.textContent) + parseInt(formData.get("quantity"))
                    }

                }

            })

        })

    })

})

</script>
<div id="cart-toast"
     class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-4 opacity-0 transition duration-300 pointer-events-none z-50">

    <span id="cart-toast-text">
        Cart Updated Successfully.
    </span>

    <button id="cart-toast-close"
            class="border border-white px-3 py-1 rounded hover:bg-white hover:text-green-600 transition">
        OK
    </button>

</div>

{{-- Footer --}}
    <footer class="bg-[#076807] text-white pt-14 pb-8">
        <div class="max-w-7xl mx-auto px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                {{-- Brand --}}
                <div>
                    <img src="{{ asset('storage/logo/logo-text-white.png') }}" alt="Go Gecko" class="h-11 mb-2 -ml-2">
                    <p class="text-green-200 text-sm leading-relaxed mb-1">A Venture of</p>
                    <p class="font-bold text-sm uppercase mb-1">Star Hygiene Solution</p>
                    <p class="text-green-300 text-sm">#StartupIndia</p>
                    <p class="text-green-300 text-sm mb-4">#ClimateChange</p>
                    <p class="text-sm"><span class="font-bold">Phone:</span> +91-7042790775</p>
                    <p class="text-sm mt-1"><span class="font-bold">Email:</span> helpdesk@gogecko.in</p>

                    {{-- Social icons --}}
                    <div class="flex items-center gap-4 mt-6">
                        <a href="https://www.facebook.com/gogecko" class="hover:text-green-300 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/in/gogecko/" class="hover:text-green-300 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14m-.5 15.5v-5.3a3.26 3.26 0 00-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 011.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 001.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 00-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/_gogecko_/" class="hover:text-green-300 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://twitter.com/gogecko" class="hover:text-green-300 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://wa.me/917042790775" class="hover:text-green-300 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Information --}}
                <div class="md:text-center">
                    <h3 class="font-bold text-sm uppercase tracking-widest text-green-300 mb-5">Information</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/" class="hover:text-green-300 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-green-300 transition">About Us</a></li>
                        <li><a href="/contact" class="hover:text-green-300 transition">Contact Us</a></li>
                        <li><a href="{{ route('clients') }}" class="hover:text-green-300 transition">Clients</a></li>
                    </ul>
                </div>

                {{-- Policies --}}
                <div class="md:text-center">
                    <h3 class="font-bold text-sm uppercase tracking-widest text-green-300 mb-5">Policies</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('terms') }}" class="hover:text-green-300 transition">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-green-300 transition">Privacy Policy</a></li>
                    </ul>
                </div>

                {{-- Links --}}
                <div class="md:text-center">
                    <h3 class="font-bold text-sm uppercase tracking-widest text-green-300 mb-5">Links</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/products" class="hover:text-green-300 transition">Our Products</a></li>
                        <li><a href="/blogs" class="hover:text-green-300 transition">Blogs</a></li>
                        <li><a href="{{ route('sitemap') }}" class="hover:text-green-300 transition">Sitemap</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-green-300 transition">Gallery</a></li>
                        <li><a href="{{ route('videos') }}" class="hover:text-green-300 transition">Videos</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>

    </body>
</html>

    </body>
</html>
