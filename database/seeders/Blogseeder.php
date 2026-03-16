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
                'content'  => json_encode([
                    [
                        'header'    => 'Packaging Has Evolved',
                        'subheader' => '',
                        'content'   => 'Gone are the days when packaging was just about keeping a product intact. Today, packaging is the first thing a customer sees, touches, and judges your brand by. For hotels, restaurants, and catering businesses, this is more important than ever.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Kraft and Corrugated: The Workhorses',
                        'content'   => 'Kraft paper boxes and corrugated shipping boxes remain the backbone of food and retail packaging. They are sturdy, cost-effective, and increasingly preferred by eco-conscious consumers. Choosing the right GSM and flute type can make a significant difference in product protection and presentation.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Sustainable Choices Matter',
                        'content'   => 'Institutions and corporates are now actively seeking vendors who offer recyclable and biodegradable packaging options. Switching to eco-friendly materials not only reduces your carbon footprint but also improves your brand image with clients who value sustainability.',
                    ],
                    [
                        'header'    => 'How GoGecko Helps',
                        'subheader' => '',
                        'content'   => 'GoGecko offers a wide range of packaging products — from bubble wrap rolls and stretch films to zip lock bags and foam sheets — all available for bulk procurement through a simple, hassle-free platform. Explore our Packaging Products category to find the right fit for your business.',
                    ],
                ]),
            ],
            [
                'title'    => 'Top 5 Corporate Gifts That Actually Impress Clients',
                'slug'     => 'top-5-corporate-gifts-that-actually-impress-clients',
                'excerpt'  => 'Choosing the right corporate gift can strengthen business relationships. We break down the five most impactful gifts that leave a lasting impression.',
                'category' => 'Corporate Gifting',
                'content'  => json_encode([
                    [
                        'header'    => 'Why Corporate Gifting Matters',
                        'subheader' => '',
                        'content'   => 'Corporate gifting is one of the most effective ways to build loyalty, show appreciation, and keep your brand top of mind. But not all gifts are created equal. The best ones are useful, well-designed, and memorable.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => '1. Premium Pen Sets',
                        'content'   => 'A well-crafted pen set in a gift box signals professionalism and attention to detail. It is a classic gift that never goes out of style, and one that gets used daily — keeping your brand visible.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => '2. Leather Notebooks',
                        'content'   => 'Executives love a quality notebook. A faux-leather A5 notebook with ruled pages is perfect for meetings, travel, and daily planning. It feels premium without being over the top.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => '3. Insulated Water Bottles',
                        'content'   => 'A double-walled stainless steel bottle is practical, eco-friendly, and used every single day. It is one of the highest-retention gifts you can give — meaning your brand stays in sight for years.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => '4. Desk Organisers',
                        'content'   => 'A sleek multi-compartment desk organiser keeps the recipient\'s workspace tidy and is a constant reminder of your brand every time they sit at their desk.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => '5. USB Flash Drives',
                        'content'   => 'In a world of data, a branded 32GB USB flash drive is both practical and appreciated. It is small, lightweight, and carries real value for any professional.',
                    ],
                    [
                        'header'    => 'Find All of These on GoGecko',
                        'subheader' => '',
                        'content'   => 'GoGecko\'s Corporate Gifting category has everything you need for bulk gifting — from pen sets and notebooks to wireless mice and desk organisers. Place your order in minutes and get it delivered to your nearest branch.',
                    ],
                ]),
            ],
            [
                'title'    => 'Housekeeping Essentials Every Hotel Should Stock',
                'slug'     => 'housekeeping-essentials-every-hotel-should-stock',
                'excerpt'  => 'A well-stocked housekeeping department is the backbone of any hotel\'s guest experience. Here are the must-have products every property should always have on hand.',
                'category' => 'Housekeeping',
                'content'  => json_encode([
                    [
                        'header'    => 'The Hidden Engine of Guest Satisfaction',
                        'subheader' => '',
                        'content'   => 'Guests rarely think about housekeeping when everything is running smoothly — and that is exactly the point. A well-equipped housekeeping team ensures rooms are spotless, amenities are replenished, and every touchpoint feels fresh. Running out of basic supplies is simply not an option.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Cleaning Cloths and Mops',
                        'content'   => 'Microfibre cleaning cloths are a staple. They clean without scratching, reduce chemical usage, and are reusable. Paired with a good spin mop and bucket set, your team can cover large floor areas efficiently and hygienically.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Cleaning Chemicals',
                        'content'   => 'An all-purpose liquid cleaner in a 5-litre concentrated format is the most cost-effective way to maintain floors, tiles, and surfaces. Always ensure your team is trained on dilution ratios to maximise value and safety.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Waste Management',
                        'content'   => 'Heavy-duty garbage bags are non-negotiable. Tear-resistant bags reduce mess and keep disposal hygienic. Stock them in bulk to avoid last-minute shortages during peak occupancy.',
                    ],
                    [
                        'header'    => '',
                        'subheader' => 'Air Fresheners',
                        'content'   => 'First impressions start the moment a guest opens a room door. A quality air freshener spray keeps corridors and rooms smelling fresh and welcoming throughout the day.',
                    ],
                    [
                        'header'    => 'Procure Smarter with GoGecko',
                        'subheader' => '',
                        'content'   => 'GoGecko\'s Housekeeping category covers everything from microfibre cloths and mops to industrial brooms and cleaning chemicals — all available for bulk ordering with delivery managed through your nearest branch. Simplify your procurement today.',
                    ],
                ]),
            ],
        ];

        foreach ($blogs as $blog) {
            DB::table('blogs')->insert([
                'title'        => $blog['title'],
                'slug'         => $blog['slug'],
                'excerpt'      => $blog['excerpt'],
                'category'     => $blog['category'],
                'content'      => $blog['content'],
                'image_path'   => null,
                'author_id'    => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}