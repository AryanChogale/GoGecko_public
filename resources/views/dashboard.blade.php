<x-app-layout>

<div
    x-data="{ slide: 1 }"
    x-init="setInterval(() => slide = slide === 8 ? 1 : slide + 1, 8000)"
    class="relative w-full overflow-hidden"
>
    <!-- Slides -->
    <div class="relative h-[200px] sm:h-[350px] md:h-[600px]">
        <a href="/products?search=&category=Packaging+Products">
            <img x-show="slide === 1"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner01.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Corporate+Gifting">
            <img x-show="slide === 2"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner02.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Hotel+Dry+Amenities">
            <img x-show="slide === 3"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner03.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Housekeeping">
            <img x-show="slide === 4"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner04.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Office+Stationary">
            <img x-show="slide === 5"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner05.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Housekeeping">
            <img x-show="slide === 6"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner06.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Housekeeping">
            <img x-show="slide === 7"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner07.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
        <a href="/products?search=&category=Pet+Containers">
            <img x-show="slide === 8"
                x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                src="{{ asset('storage/slides/banner08.jpg') }}"
                class="absolute w-full h-full object-cover">
        </a>
    </div>

    <!-- Left Button -->
    <button @click="slide = slide === 1 ? 8 : slide - 1"
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white p-1.5 md:p-2 rounded">
        <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-4 h-4 md:w-6 md:h-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
    </button>

    <!-- Right Button -->
    <button @click="slide = slide === 8 ? 1 : slide + 1"
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white p-1.5 md:p-2 rounded">
        <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-4 h-4 md:w-6 md:h-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
    </button>
</div>

{{-- Vision & About --}}
<section class="bg-[#E9EFE5] py-10 md:py-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 items-center px-6 gap-6">
        <div class="bg-[#076807] text-white p-6 md:p-10 rounded-xl shadow-lg">
            <h2 class="text-xl md:text-2xl font-bold mb-4">Gecko's Vision</h2>
            <p class="mb-6 leading-relaxed text-sm md:text-base">
                To create Simple, Dynamic, Adaptable cloud-based platform which will bring a
                fundamental change in procurement process by Institutions, HORECA and Cooperates.
            </p>
            <h2 class="text-xl md:text-2xl font-bold mb-4">What is GoGecko</h2>
            <p class="mb-8 leading-relaxed text-sm md:text-base">
                GeGecko is a venture of Star hygiene solution. It is unique futuristic cloud-based
                platform which will enhance the experience of procurement of different materials
                in Institutions, HORECA and Cooperates.
            </p>
            <div class="flex justify-center">
                <a href="/products"
                   class="inline-block bg-[#38b000] hover:bg-white hover:text-[#38b000] text-white font-semibold px-6 py-3 rounded-full transition">
                    Explore Products
                </a>
            </div>
        </div>
        <div
            x-data="{ slide: 1 }"
            x-init="setInterval(() => slide = slide === 5 ? 1 : slide + 1, 8000)"
            class="relative w-full h-[250px] md:h-[400px] rounded-xl overflow-hidden shadow-lg"
        >
            <img x-show="slide === 1" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ asset('storage/slides/product1.jpg') }}" class="absolute w-full h-full object-cover">
            <img x-show="slide === 2" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ asset('storage/slides/product2.jpg') }}" class="absolute w-full h-full object-cover">
            <img x-show="slide === 3" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ asset('storage/slides/product3.jpg') }}" class="absolute w-full h-full object-cover">
            <img x-show="slide === 4" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ asset('storage/slides/product4.jpg') }}" class="absolute w-full h-full object-cover">
            <img x-show="slide === 5" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" src="{{ asset('storage/slides/product5.jpg') }}" class="absolute w-full h-full object-cover">
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-12 md:py-20 bg-[#E9EFE5]">
    <div class="text-center mb-8 md:mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-green-700">Our Categories</h2>
        <p class="text-gray-600 mt-2">Comprehensive List of Products</p>
    </div>

    <div class="max-w-6xl mx-auto px-6">

        {{-- Mobile: simple 2-column grid --}}
        <div class="grid grid-cols-2 gap-4 md:hidden">
            <a href="/products?search=&category=Packaging+Products" class="relative rounded-xl overflow-hidden h-36">
                <img src="{{ asset('storage/categories/packaging.jpg') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-3">
                    <h3 class="text-white text-xs font-semibold text-center">Packaging Products</h3>
                </div>
            </a>
            <a href="/products?search=&category=Corporate+Gifting" class="relative rounded-xl overflow-hidden h-36">
                <img src="{{ asset('storage/categories/corporate.jpg') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-3">
                    <h3 class="text-white text-xs font-semibold text-center">Corporate Gifting</h3>
                </div>
            </a>
            <a href="/products?search=&category=Pet+Containers" class="relative rounded-xl overflow-hidden h-36">
                <img src="{{ asset('storage/categories/containers.jpg') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-3">
                    <h3 class="text-white text-xs font-semibold text-center">Pet Containers</h3>
                </div>
            </a>
            <a href="/products?search=&category=Disposables" class="relative rounded-xl overflow-hidden h-36">
                <img src="{{ asset('storage/categories/disposables.jpg') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-3">
                    <h3 class="text-white text-xs font-semibold text-center">Disposables</h3>
                </div>
            </a>
            <a href="/products?search=&category=Housekeeping" class="relative rounded-xl overflow-hidden h-36 col-span-2">
                <img src="{{ asset('storage/categories/housekeeping.jpg') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-3">
                    <h3 class="text-white text-xs font-semibold text-center">Housekeeping</h3>
                </div>
            </a>
        </div>

        {{-- Desktop: original bento grid --}}
        <div class="hidden md:grid grid-cols-3 gap-6">
            <div class="col-span-1 row-span-2 relative rounded-xl overflow-hidden">
                <a href="/products?search=&category=Packaging+Products" class="block w-full h-full">
                    <img src="{{ asset('storage/categories/packaging.jpg') }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-6">
                        <h3 class="text-white text-lg font-semibold">Packaging Products</h3>
                    </div>
                </a>
            </div>
            <div class="relative rounded-xl overflow-hidden h-56">
                <a href="/products?search=&category=Corporate+Gifting" class="block w-full h-full">
                    <img src="{{ asset('storage/categories/corporate.jpg') }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-6">
                        <h3 class="text-white font-semibold">Corporate Gifting</h3>
                    </div>
                </a>
            </div>
            <div class="relative rounded-xl overflow-hidden h-56">
                <a href="/products?search=&category=Pet+Containers" class="block w-full h-full">
                    <img src="{{ asset('storage/categories/containers.jpg') }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-6">
                        <h3 class="text-white font-semibold">Pet Containers</h3>
                    </div>
                </a>
            </div>
            <div class="relative rounded-xl overflow-hidden h-56">
                <a href="/products?search=&category=Disposables" class="block w-full h-full">
                    <img src="{{ asset('storage/categories/disposables.jpg') }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-6">
                        <h3 class="text-white font-semibold">Disposables</h3>
                    </div>
                </a>
            </div>
            <div class="relative rounded-xl overflow-hidden h-56">
                <a href="/products?search=&category=Housekeeping" class="block w-full h-full">
                    <img src="{{ asset('storage/categories/housekeeping.jpg') }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-end justify-center pb-6">
                        <h3 class="text-white font-semibold">Housekeeping</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Clients --}}
<section class="py-12 md:py-16 bg-[#E9EFE5]">
    <h2 class="text-center text-xl md:text-2xl font-semibold text-gray-700 mb-8 md:mb-10">Our Clients</h2>
    <div class="max-w-6xl mx-auto px-6">
        <div class="swiper clientSwiper">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 19; $i++)
                    <div class="swiper-slide flex justify-center items-center">
                        <img src="{{ asset('storage/clients/' . $i . '.jpg') }}" class="h-12 md:h-16 object-contain transition">
                    </div>
                @endfor
            </div>
            <div class="swiper-button-next">
                <svg viewBox="0 0 20 20" fill="#000" class="chevron-right w-6 h-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="swiper-button-prev">
                <svg viewBox="0 0 20 20" fill="#000" class="chevron-left w-6 h-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="bg-[#E9EFE5] py-8 md:py-12">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center px-6">
        <div class="flex items-center justify-center gap-3 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 13h13v6H3z"/><path d="M16 16l3 0 2-3v-2h-5z"/><circle cx="7" cy="20" r="1"/><circle cx="17" cy="20" r="1"/></svg>
            <span class="text-sm">Hassle Free Delivery</span>
        </div>
        <div class="flex items-center justify-center gap-3 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2v4"/><path d="M4.9 4.9l2.8 2.8"/><path d="M2 12h4"/><path d="M4.9 19.1l2.8-2.8"/><path d="M12 22v-4"/><path d="M19.1 19.1l-2.8-2.8"/><path d="M22 12h-4"/><path d="M19.1 4.9l-2.8 2.8"/><circle cx="12" cy="12" r="3"/></svg>
            <span class="text-sm">Customisation</span>
        </div>
        <div class="flex items-center justify-center gap-3 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10h6"/></svg>
            <span class="text-sm">Quick Delivery</span>
        </div>
        <div class="flex items-center justify-center gap-3 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 010 20"/><path d="M12 2a15 15 0 000 20"/></svg>
            <span class="text-sm">Global Standard Products</span>
        </div>
    </div>
</section>

{{-- Why GoGecko --}}
<section class="relative py-10 md:py-14 text-white mt-5">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/slides/why.jpg') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    <div class="relative max-w-5xl mx-auto text-center px-6">
        <h2 class="text-2xl md:text-3xl font-semibold mb-6">Why GoGecko</h2>
        <p class="mb-4 text-sm md:text-base"><strong>GoGecko is Simple.</strong> It is easy to use. GoGecko platform has unique user-friendly interface which allows hassle-free ordering process.</p>
        <p class="mb-4 text-sm md:text-base"><strong>GoGecko is Dynamic.</strong> It is a futuristic cloud-based platform enabling Institutions, HORECA and Corporates to manage procurement with real-time tracking and customization.</p>
        <p class="mb-8 text-sm md:text-base"><strong>GoGecko is Adaptable.</strong> One stop solution for Food & Commercial Packing, Guest Room Amenities, Housekeeping, Stationary, Toiletries and more.</p>
        <div class="flex justify-center">
            <a href="/products" class="inline-block bg-[#38b000] hover:bg-white hover:text-[#38b000] text-white font-semibold px-6 py-3 rounded-full transition">Explore Products</a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section id="stats" class="bg-[#076807] text-white py-5 mt-10">
    <h2 class="text-center text-2xl md:text-3xl font-semibold mb-8 md:mb-12">Our Achievement</h2>
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10 text-center px-6">
        <div>
            <h3 class="text-3xl md:text-4xl font-bold counter" data-target="25">0</h3>
            <p class="mt-2 text-sm md:text-base">Years of Experience</p>
        </div>
        <div>
            <h3 class="text-3xl md:text-4xl font-bold counter" data-target="100000">0</h3>
            <p class="mt-2 text-sm md:text-base">No of products sold</p>
        </div>
        <div>
            <h3 class="text-3xl md:text-4xl font-bold counter" data-target="50">0</h3>
            <p class="mt-2 text-sm md:text-base">Satisfied Clients</p>
        </div>
        <div>
            <h3 class="text-3xl md:text-4xl font-bold counter" data-target="15">0</h3>
            <p class="mt-2 text-sm md:text-base">Team</p>
        </div>
    </div>
</section>

{{-- Products carousel --}}
<section class="py-12 md:py-20 bg-[#E9EFE5]">
    <h2 class="text-center text-2xl md:text-3xl font-semibold text-gray-700 mb-8 md:mb-12">Our Products</h2>
    <div class="max-w-6xl mx-auto px-6">
        <div class="swiper productSwiper">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="swiper-slide">
                        <a href="/products" class="block bg-white shadow rounded-lg">
                            <div class="overflow-hidden">
                                <img src="{{ asset('storage/productslide/' . $i . '.jpg') }}" class="w-full h-48 md:h-70 object-cover transition duration-500 hover:scale-110">
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
            <div class="swiper-button-prev">
                <svg viewBox="0 0 20 20" fill="#000" class="w-6 h-6 rotate-180"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <div class="swiper-button-next">
                <svg viewBox="0 0 20 20" fill="#000" class="w-6 h-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>
    <div class="flex justify-center pt-8 md:pt-10">
        <a href="/products" class="inline-block bg-[#38b000] hover:bg-white hover:text-[#38b000] text-white font-semibold px-6 py-3 rounded-full transition">Check All Products</a>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-12 md:py-20 bg-[#E9EFE5]">
    <h2 class="text-center text-2xl md:text-3xl font-semibold text-gray-700 mb-8 md:mb-12">Our Testimonials</h2>
    <div class="max-w-5xl mx-auto flex items-center gap-4 md:gap-6 px-6">
        <div class="testimonial-prev cursor-pointer shrink-0">
            <svg viewBox="0 0 20 20" fill="#000" class="w-6 h-6 rotate-180"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        </div>
        <div class="swiper testimonialSwiper flex-1">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="border border-gray-300 rounded-lg p-6 md:p-10 text-center">
                        <p class="text-gray-600 mb-6 leading-relaxed text-sm md:text-base">
                            I am so grateful for the GoGecko. Everything I need is the simplified user-based platform which is simple, efficient in the use of housekeeping products. I'll be using this platform since this is literally the best thing I have found.
                        </p>
                        <span class="text-green-600 font-semibold">Ashutosh Gupta</span>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="border border-gray-300 rounded-lg p-6 md:p-10 text-center">
                        <p class="text-gray-600 mb-6 leading-relaxed text-sm md:text-base">
                            GoGecko has been a phenomenal platform to me. Being a client, I've used this cloud-based platform for ordering a bunch of housekeeping and amenity products. I found it extremely simple and easy to order which saved a lot of time. I highly recommend to use GoGecko. I wish all the best to GoGecko.
                        </p>
                        <span class="text-green-600 font-semibold">Prashant Kapoor</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonial-next cursor-pointer shrink-0">
            <svg viewBox="0 0 20 20" fill="#000" class="w-6 h-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
        </div>
    </div>
</section>

</x-app-layout>
