<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // ── Packaging Products ──
            ['name' => 'Brown Kraft Paper Box',              'category' => 'Packaging Products', 'sub_category' => 'Boxes',      'price' => 45,   'quantity' => 500, 'description' => 'Durable kraft paper box suitable for food and retail packaging. Available in multiple sizes.'],
            ['name' => 'Corrugated Shipping Box',             'category' => 'Packaging Products', 'sub_category' => 'Boxes',      'price' => 85,   'quantity' => 300, 'description' => 'Heavy-duty corrugated box for safe shipping and storage of goods.'],
            ['name' => 'Bubble Wrap Roll (50m)',              'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 320,  'quantity' => 150, 'description' => 'Premium bubble wrap roll providing excellent cushioning for fragile items.'],
            ['name' => 'Stretch Wrap Film',                   'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 210,  'quantity' => 200, 'description' => 'Clear stretch film for securing pallets and bundling products together.'],
            ['name' => 'Packing Tape (Set of 6)',             'category' => 'Packaging Products', 'sub_category' => 'Tapes',      'price' => 120,  'quantity' => 400, 'description' => 'Strong adhesive packing tape for sealing cartons and packages securely.'],
            ['name' => 'Zip Lock Bags (100 pcs)',             'category' => 'Packaging Products', 'sub_category' => 'Pouches',    'price' => 95,   'quantity' => 600, 'description' => 'Food-grade zip lock bags in assorted sizes for storage and packaging.'],
            ['name' => 'Foam Packing Sheets',                 'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 180,  'quantity' => 250, 'description' => 'Soft foam sheets for wrapping and protecting delicate products during transit.'],

            // ── Corporate Gifting ──
            ['name' => 'Premium Ball Pen Set',                'category' => 'Corporate Gifting',  'sub_category' => 'Stationery', 'price' => 299,  'quantity' => 200, 'description' => 'Set of 5 smooth-writing ball pens in a gift box. Ideal for corporate giveaways.'],
            ['name' => 'Analog Desk Clock',                   'category' => 'Corporate Gifting',  'sub_category' => 'Desk Items', 'price' => 649,  'quantity' => 100, 'description' => 'Elegant analog desk clock with wooden base. A timeless corporate gift.'],
            ['name' => 'Leather Notebook A5',                 'category' => 'Corporate Gifting',  'sub_category' => 'Stationery', 'price' => 399,  'quantity' => 150, 'description' => 'Premium faux-leather A5 notebook with 200 ruled pages. Perfect for executives.'],
            ['name' => 'USB Flash Drive 32GB',                'category' => 'Corporate Gifting',  'sub_category' => 'Tech',       'price' => 449,  'quantity' => 180, 'description' => 'Branded USB flash drive with 32GB storage. Useful and memorable corporate gift.'],
            ['name' => 'Stainless Steel Water Bottle',        'category' => 'Corporate Gifting',  'sub_category' => 'Drinkware',  'price' => 599,  'quantity' => 120, 'description' => 'Double-walled insulated steel bottle keeping drinks hot or cold for hours.'],
            ['name' => 'Wireless Mouse',                      'category' => 'Corporate Gifting',  'sub_category' => 'Tech',       'price' => 799,  'quantity' => 90,  'description' => 'Ergonomic wireless mouse with silent click. Great tech gift for professionals.'],
            ['name' => 'Desk Organiser Set',                  'category' => 'Corporate Gifting',  'sub_category' => 'Desk Items', 'price' => 549,  'quantity' => 110, 'description' => 'Multi-compartment desk organiser for pens, cards, and stationery. Sleek design.'],

            // ── Pet Containers ──
            ['name' => 'PET Bottle 500ml (50 pcs)',           'category' => 'Pet Containers',     'sub_category' => 'Bottles',    'price' => 380,  'quantity' => 400, 'description' => 'Clear PET bottles with screw caps. Food-grade and BPA-free. Pack of 50.'],
            ['name' => 'PET Jar 250ml (30 pcs)',              'category' => 'Pet Containers',     'sub_category' => 'Jars',       'price' => 290,  'quantity' => 300, 'description' => 'Wide-mouth PET jars ideal for dry foods, spices, and cosmetic products.'],
            ['name' => 'PET Bottle 1 Litre (25 pcs)',         'category' => 'Pet Containers',     'sub_category' => 'Bottles',    'price' => 420,  'quantity' => 250, 'description' => 'Large 1-litre PET bottles suitable for juices, sauces, and liquid products.'],
            ['name' => 'Trigger Spray Bottle 750ml',          'category' => 'Pet Containers',     'sub_category' => 'Spray',      'price' => 95,   'quantity' => 350, 'description' => 'Durable PET trigger spray bottle for cleaning products and gardening use.'],
            ['name' => 'Cosmetic Pump Bottle 200ml',          'category' => 'Pet Containers',     'sub_category' => 'Pump',       'price' => 65,   'quantity' => 500, 'description' => 'Elegant PET pump dispenser bottle suitable for lotions, soaps, and serums.'],

            // ── Disposables ──
            ['name' => 'Disposable Plates (50 pcs)',          'category' => 'Disposables',        'sub_category' => 'Tableware',  'price' => 140,  'quantity' => 500, 'description' => 'Sturdy disposable plates suitable for events, canteens, and food service.'],
            ['name' => 'Plastic Cups 200ml (100 pcs)',        'category' => 'Disposables',        'sub_category' => 'Tableware',  'price' => 110,  'quantity' => 600, 'description' => 'Lightweight disposable cups ideal for water, juice, and beverages.'],
            ['name' => 'Disposable Spoon & Fork Set',         'category' => 'Disposables',        'sub_category' => 'Cutlery',    'price' => 85,   'quantity' => 700, 'description' => 'Pack of 50 each — disposable plastic spoons and forks for catering use.'],
            ['name' => 'Aluminium Foil Container',            'category' => 'Disposables',        'sub_category' => 'Food Packs', 'price' => 220,  'quantity' => 400, 'description' => 'Oven-safe aluminium foil containers for takeaway food and meal prep.'],
            ['name' => 'Disposable Gloves (100 pcs)',         'category' => 'Disposables',        'sub_category' => 'Safety',     'price' => 175,  'quantity' => 800, 'description' => 'Powder-free disposable gloves for hygiene and food handling applications.'],
            ['name' => 'Paper Bags (50 pcs)',                 'category' => 'Disposables',        'sub_category' => 'Bags',       'price' => 195,  'quantity' => 450, 'description' => 'Eco-friendly kraft paper carry bags with handles. Available in two sizes.'],

            // ── Housekeeping ──
            ['name' => 'Microfibre Cleaning Cloth (5 pcs)',   'category' => 'Housekeeping',       'sub_category' => 'Cleaning',   'price' => 199,  'quantity' => 300, 'description' => 'Ultra-soft microfibre cloths for dust-free cleaning of surfaces and glass.'],
            ['name' => 'Mop with Bucket Set',                 'category' => 'Housekeeping',       'sub_category' => 'Cleaning',   'price' => 849,  'quantity' => 80,  'description' => 'Spin mop and bucket combo for efficient floor cleaning in large spaces.'],
            ['name' => 'Industrial Broom',                    'category' => 'Housekeeping',       'sub_category' => 'Sweeping',   'price' => 299,  'quantity' => 120, 'description' => 'Heavy-duty broom with stiff bristles for sweeping hard floors and outdoor areas.'],
            ['name' => 'All-Purpose Cleaner 5L',              'category' => 'Housekeeping',       'sub_category' => 'Chemicals',  'price' => 450,  'quantity' => 200, 'description' => 'Concentrated all-purpose liquid cleaner for floors, tiles, and surfaces.'],
            ['name' => 'Garbage Bags (50 pcs)',               'category' => 'Housekeeping',       'sub_category' => 'Waste',      'price' => 160,  'quantity' => 500, 'description' => 'Heavy-duty garbage bags in black. Tear-resistant for office and hotel use.'],
            ['name' => 'Air Freshener Spray 300ml',           'category' => 'Housekeeping',       'sub_category' => 'Fragrance',  'price' => 189,  'quantity' => 250, 'description' => 'Long-lasting air freshener spray for rooms, washrooms, and common areas.'],

            // ── Hotel Dry Amenities ──
            ['name' => 'Shampoo Sachet (100 pcs)',            'category' => 'Hotel Dry Amenities','sub_category' => 'Hair Care',  'price' => 350,  'quantity' => 600, 'description' => 'Single-use hotel shampoo sachets with mild fragrance. Bulk pack of 100.'],
            ['name' => 'Conditioner Sachet (100 pcs)',        'category' => 'Hotel Dry Amenities','sub_category' => 'Hair Care',  'price' => 350,  'quantity' => 600, 'description' => 'Hotel-grade conditioner sachets for smooth and manageable hair.'],
            ['name' => 'Bath Soap Bar (50 pcs)',              'category' => 'Hotel Dry Amenities','sub_category' => 'Body Care',  'price' => 480,  'quantity' => 400, 'description' => 'Premium hotel soap bars with moisturising formula. Individually wrapped.'],
            ['name' => 'Shower Cap (50 pcs)',                 'category' => 'Hotel Dry Amenities','sub_category' => 'Accessories','price' => 195,  'quantity' => 700, 'description' => 'Disposable shower caps in polythene. Standard hotel room amenity.'],
            ['name' => 'Dental Kit (50 pcs)',                 'category' => 'Hotel Dry Amenities','sub_category' => 'Oral Care',  'price' => 420,  'quantity' => 500, 'description' => 'Hotel dental kit with toothbrush and toothpaste. Individually packed.'],
            ['name' => 'Sewing Kit (50 pcs)',                 'category' => 'Hotel Dry Amenities','sub_category' => 'Accessories','price' => 275,  'quantity' => 300, 'description' => 'Compact hotel sewing kit with needle, thread, and buttons. Guest room essential.'],
            ['name' => 'Moisturiser Lotion Sachet (100 pcs)', 'category' => 'Hotel Dry Amenities','sub_category' => 'Body Care',  'price' => 390,  'quantity' => 500, 'description' => 'Single-use body lotion sachets for hotel guest rooms and spa use.'],

            // ── Office Stationery ──
            ['name' => 'A4 Copier Paper (500 sheets)',        'category' => 'Office Stationery',  'sub_category' => 'Paper',      'price' => 299,  'quantity' => 400, 'description' => 'High-quality 75 GSM A4 copy paper for laser and inkjet printers.'],
            ['name' => 'Stapler with Pins',                   'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 199,  'quantity' => 150, 'description' => 'Heavy-duty office stapler with a pack of 1000 staple pins included.'],
            ['name' => 'Whiteboard Markers (Set of 4)',       'category' => 'Office Stationery',  'sub_category' => 'Markers',    'price' => 149,  'quantity' => 200, 'description' => 'Dry-erase whiteboard markers in 4 colours. Smooth writing, easy to wipe.'],
            ['name' => 'Sticky Notes (5 Pads)',               'category' => 'Office Stationery',  'sub_category' => 'Paper',      'price' => 129,  'quantity' => 300, 'description' => 'Bright coloured sticky note pads for reminders and quick messages.'],
            ['name' => 'Scissors (Pack of 2)',                'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 119,  'quantity' => 180, 'description' => 'Sharp stainless steel office scissors with comfortable grip handles.'],
            ['name' => 'File Folders (Pack of 10)',           'category' => 'Office Stationery',  'sub_category' => 'Filing',     'price' => 175,  'quantity' => 250, 'description' => 'Durable A4 file folders for organising documents and reports.'],
            ['name' => 'Correction Pen',                      'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 49,   'quantity' => 400, 'description' => 'Quick-drying correction fluid pen for neat error correction on paper.'],

        ];

        foreach ($products as $product) {
            $label     = rawurlencode($product['name']);
            $imagePath = "https://placehold.co/400x300/E9EFE5/076807?text={$label}";

            DB::table('products')->insert([
                'name'         => $product['name'],
                'category'     => $product['category'],
                'sub_category' => $product['sub_category'],
                'price'        => $product['price'],
                'quantity'     => $product['quantity'],
                'description'  => $product['description'],
                'image_path'   => $imagePath,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}