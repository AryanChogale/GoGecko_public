<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title'    => 'Why Smart Packaging is the Future of HORECA',
                'slug'     => 'why-smart-packaging-is-the-future-of-horeca',
                'excerpt'  => 'From kraft boxes to eco-friendly wrapping, packaging is no longer just a container — it\'s a brand statement. Here\'s what HORECA businesses need to know.',
                'category' => 'Packaging Products',
                'image'    => 'blogs/portable-brown-kraft-paper-tea-fruit-gift-packaging-box.jpg',
                'content'  => json_encode([
                    ['header' => 'Packaging Has Evolved',        'subheader' => '', 'content' => 'Gone are the days when packaging was just about keeping a product intact. Today, packaging is the first thing a customer sees, touches, and judges your brand by. For hotels, restaurants, and catering businesses, this is more important than ever.'],
                    ['header' => '', 'subheader' => 'Kraft and Corrugated: The Workhorses', 'content' => 'Kraft paper boxes and corrugated shipping boxes remain the backbone of food and retail packaging. They are sturdy, cost-effective, and increasingly preferred by eco-conscious consumers. Choosing the right GSM and flute type can make a significant difference in product protection and presentation.'],
                    ['header' => '', 'subheader' => 'Sustainable Choices Matter', 'content' => 'Institutions and corporates are now actively seeking vendors who offer recyclable and biodegradable packaging options. Switching to eco-friendly materials not only reduces your carbon footprint but also improves your brand image with clients who value sustainability.'],
                    ['header' => 'How GoGecko Helps', 'subheader' => '', 'content' => 'GoGecko offers a wide range of packaging products — from bubble wrap rolls and stretch films to zip lock bags and foam sheets — all available for bulk procurement through a simple, hassle-free platform. Explore our Packaging Products category to find the right fit for your business.'],
                ]),
            ],
            [
                'title'    => 'Top 5 Corporate Gifts That Actually Impress Clients',
                'slug'     => 'top-5-corporate-gifts-that-actually-impress-clients',
                'excerpt'  => 'Choosing the right corporate gift can strengthen business relationships. We break down the five most impactful gifts that leave a lasting impression.',
                'category' => 'Corporate Gifting',
                'image'    => 'blogs/rope-bottle-diary-pen-cardholder-desk-clock-black.webp',
                'content'  => json_encode([
                    ['header' => 'Why Corporate Gifting Matters', 'subheader' => '', 'content' => 'Corporate gifting is one of the most effective ways to build loyalty, show appreciation, and keep your brand top of mind. But not all gifts are created equal. The best ones are useful, well-designed, and memorable.'],
                    ['header' => '', 'subheader' => '1. Premium Pen Sets', 'content' => 'A well-crafted pen set in a gift box signals professionalism and attention to detail. It is a classic gift that never goes out of style, and one that gets used daily — keeping your brand visible.'],
                    ['header' => '', 'subheader' => '2. Leather Notebooks', 'content' => 'Executives love a quality notebook. A faux-leather A5 notebook with ruled pages is perfect for meetings, travel, and daily planning. It feels premium without being over the top.'],
                    ['header' => '', 'subheader' => '3. Insulated Water Bottles', 'content' => 'A double-walled stainless steel bottle is practical, eco-friendly, and used every single day. It is one of the highest-retention gifts you can give — meaning your brand stays in sight for years.'],
                    ['header' => '', 'subheader' => '4. Desk Organisers', 'content' => 'A sleek multi-compartment desk organiser keeps the recipient\'s workspace tidy and is a constant reminder of your brand every time they sit at their desk.'],
                    ['header' => '', 'subheader' => '5. USB Flash Drives', 'content' => 'In a world of data, a branded 32GB USB flash drive is both practical and appreciated. It is small, lightweight, and carries real value for any professional.'],
                    ['header' => 'Find All of These on GoGecko', 'subheader' => '', 'content' => 'GoGecko\'s Corporate Gifting category has everything you need for bulk gifting — from pen sets and notebooks to wireless mice and desk organisers. Place your order in minutes and get it delivered to your nearest branch.'],
                ]),
            ],
            [
                'title'    => 'Housekeeping Essentials Every Hotel Should Stock',
                'slug'     => 'housekeeping-essentials-every-hotel-should-stock',
                'excerpt'  => 'A well-stocked housekeeping department is the backbone of any hotel\'s guest experience. Here are the must-have products every property should always have on hand.',
                'category' => 'Housekeeping',
                'image'    => 'blogs/housekeeping-cleaning-person-with-mop-clean-floor-office-domestic-worker-cleaner_93150-39589.avif',
                'content'  => json_encode([
                    ['header' => 'The Hidden Engine of Guest Satisfaction', 'subheader' => '', 'content' => 'Guests rarely think about housekeeping when everything is running smoothly — and that is exactly the point. A well-equipped housekeeping team ensures rooms are spotless, amenities are replenished, and every touchpoint feels fresh. Running out of basic supplies is simply not an option.'],
                    ['header' => '', 'subheader' => 'Cleaning Cloths and Mops', 'content' => 'Microfibre cleaning cloths are a staple. They clean without scratching, reduce chemical usage, and are reusable. Paired with a good spin mop and bucket set, your team can cover large floor areas efficiently and hygienically.'],
                    ['header' => '', 'subheader' => 'Cleaning Chemicals', 'content' => 'An all-purpose liquid cleaner in a 5-litre concentrated format is the most cost-effective way to maintain floors, tiles, and surfaces. Always ensure your team is trained on dilution ratios to maximise value and safety.'],
                    ['header' => '', 'subheader' => 'Waste Management', 'content' => 'Heavy-duty garbage bags are non-negotiable. Tear-resistant bags reduce mess and keep disposal hygienic. Stock them in bulk to avoid last-minute shortages during peak occupancy.'],
                    ['header' => '', 'subheader' => 'Air Fresheners', 'content' => 'First impressions start the moment a guest opens a room door. A quality air freshener spray keeps corridors and rooms smelling fresh and welcoming throughout the day.'],
                    ['header' => 'Procure Smarter with GoGecko', 'subheader' => '', 'content' => 'GoGecko\'s Housekeeping category covers everything from microfibre cloths and mops to industrial brooms and cleaning chemicals — all available for bulk ordering with delivery managed through your nearest branch. Simplify your procurement today.'],
                ]),
            ],
            [
                'title'    => 'The Complete Guide to Hotel Guest Room Amenities',
                'slug'     => 'the-complete-guide-to-hotel-guest-room-amenities',
                'excerpt'  => 'From shampoo sachets to dental kits, the right guest room amenities define your hotel\'s quality. Here\'s what every property should offer.',
                'category' => 'Hotel Dry Amenities',
                'image'    => 'blogs/hotel-spa-amenities-wooden-tray-hotel-spa-amenities-wooden-tray-copy-space-185295836.webp',
                'content'  => json_encode([
                    ['header' => 'First Impressions Begin in the Bathroom', 'subheader' => '', 'content' => 'The guest room bathroom is one of the first things a guest inspects. A neatly arranged tray of amenities signals quality, care, and attention to detail. It sets the tone for the entire stay before the guest has even unpacked.'],
                    ['header' => '', 'subheader' => 'Hair Care Essentials', 'content' => 'Shampoo and conditioner sachets are non-negotiable. Single-use sachets are hygienic, easy to stock, and preferred by guests over shared dispensers. Choose mild, pleasant fragrances that suit a wide range of guests.'],
                    ['header' => '', 'subheader' => 'Body Care and Soap', 'content' => 'Individually wrapped soap bars and moisturiser sachets elevate the perceived quality of your property. Guests associate wrapped amenities with hygiene and exclusivity — a small investment with a significant impact on reviews.'],
                    ['header' => '', 'subheader' => 'Practical Extras That Get Noticed', 'content' => 'Dental kits, shower caps, and sewing kits are the amenities guests only notice when they are missing. Stocking them consistently builds trust and earns positive mentions in guest feedback and online reviews.'],
                    ['header' => 'Bulk Procurement Made Simple', 'subheader' => '', 'content' => 'GoGecko\'s Hotel Dry Amenities category offers everything from shampoo sachets and soap bars to dental kits and sewing kits — all available for bulk ordering. Consistent quality, hassle-free delivery to your nearest branch.'],
                ]),
            ],
            [
                'title'    => 'Why Switching to Quality Disposables Saves Your Business Money',
                'slug'     => 'why-switching-to-quality-disposables-saves-your-business-money',
                'excerpt'  => 'Many HORECA businesses underestimate the cost of cheap disposables. Here\'s how investing in quality disposables actually reduces long-term operational costs.',
                'category' => 'Disposables',
                'image'    => 'blogs/vibrant-assortment-colorful-paper-plates-cups-arranged-neatly-white-background-eco-friendly-disposable-tableware-festive-398825323.webp',
                'content'  => json_encode([
                    ['header' => 'The Hidden Cost of Cheap Disposables', 'subheader' => '', 'content' => 'When businesses buy the cheapest disposable plates, cups, and cutlery available, they often end up spending more — on replacements, complaints, and the operational hassle of products that fail mid-service. Quality disposables pay for themselves.'],
                    ['header' => '', 'subheader' => 'Plates and Cups That Hold Up', 'content' => 'Sturdy disposable plates and 200ml cups that do not buckle under food weight or hot beverages reduce wastage and guest complaints at events and canteens. The per-unit cost difference is minimal compared to the savings in waste.'],
                    ['header' => '', 'subheader' => 'Foil Containers for Food Safety', 'content' => 'Aluminium foil containers are oven-safe, leak-proof, and ideal for takeaway and meal prep operations. Investing in proper foil containers reduces spillage incidents and maintains food temperature — both critical for catering businesses.'],
                    ['header' => '', 'subheader' => 'Gloves and Hygiene Compliance', 'content' => 'Powder-free disposable gloves are a hygiene and compliance requirement for food handling. Running out or using substandard gloves can result in health code violations. Bulk stocking quality gloves is simply non-negotiable.'],
                    ['header' => 'Stock Smarter with GoGecko', 'subheader' => '', 'content' => 'GoGecko\'s Disposables category covers plates, cups, cutlery, foil containers, gloves, and paper bags — all available for bulk procurement. Order once, stock well, and focus on running your business.'],
                ]),
            ],
            [
                'title'    => 'Building a Productive Office: The Stationery Essentials Checklist',
                'slug'     => 'building-a-productive-office-the-stationery-essentials-checklist',
                'excerpt'  => 'A well-stocked office runs smoother. Here is the definitive checklist of stationery every workplace should have on hand at all times.',
                'category' => 'Office Stationery',
                'image'    => 'blogs/desk_organized.jpg',
                'content'  => json_encode([
                    ['header' => 'Why Stationery Stocks Matter', 'subheader' => '', 'content' => 'Running out of printer paper during a deadline, or not having a stapler when you need one, disrupts workflow and frustrates staff. Maintaining a well-stocked stationery supply is one of the simplest ways to keep an office running efficiently.'],
                    ['header' => '', 'subheader' => 'Paper and Filing', 'content' => 'A4 copier paper is the single most consumed office supply. Keep at least one ream per printer per week. Pair it with file folders for document organisation — structured filing saves hours of searching time across the team.'],
                    ['header' => '', 'subheader' => 'Writing and Correction Tools', 'content' => 'Ball pens, whiteboard markers, and correction pens are daily essentials. Whiteboard markers in four colours make meeting rooms more effective. Sticky notes remain one of the most versatile communication tools in any office.'],
                    ['header' => '', 'subheader' => 'Tools Every Desk Needs', 'content' => 'A stapler with pins, a pair of scissors, and a correction pen round out the essentials. These are the items that go missing most often and cause the most disruption when unavailable. Keep spares in the supply cabinet.'],
                    ['header' => 'Order in Bulk, Save More', 'subheader' => '', 'content' => 'GoGecko\'s Office Stationery category covers everything on this checklist — from A4 paper and file folders to sticky notes, markers, and staplers. Bulk ordering through GoGecko means you never run out, and your cost per unit stays low.'],
                ]),
            ],
        ];

        foreach ($blogs as $blog) {
            DB::table('blogs')->insert([
                'title'      => $blog['title'],
                'slug'       => $blog['slug'],
                'excerpt'    => $blog['excerpt'],
                'category'   => $blog['category'],
                'content'    => $blog['content'],
                'image_path' => $blog['image'],
                'author_id'  => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}