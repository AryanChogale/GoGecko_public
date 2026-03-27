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
            ['name' => 'Brown Kraft Paper Box',              'category' => 'Packaging Products', 'sub_category' => 'Boxes',      'price' => 45,   'quantity' => 500, 'description' => 'Durable kraft paper box suitable for food and retail packaging. Available in multiple sizes.',        'image' => 'products/kraft_box.jpg'],
            ['name' => 'Corrugated Shipping Box',             'category' => 'Packaging Products', 'sub_category' => 'Boxes',      'price' => 85,   'quantity' => 300, 'description' => 'Heavy-duty corrugated box for safe shipping and storage of goods.',                                     'image' => 'products/corrugated_shipping_box.jpeg'],
            ['name' => 'Bubble Wrap Roll (50m)',              'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 320,  'quantity' => 150, 'description' => 'Premium bubble wrap roll providing excellent cushioning for fragile items.',                            'image' => 'products/bubble_wrap_roll.jpg'],
            ['name' => 'Stretch Wrap Film',                   'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 210,  'quantity' => 200, 'description' => 'Clear stretch film for securing pallets and bundling products together.',                              'image' => 'products/stretch_wrap_film_pallet.jpg'],
            ['name' => 'Packing Tape (Set of 6)',             'category' => 'Packaging Products', 'sub_category' => 'Tapes',      'price' => 120,  'quantity' => 400, 'description' => 'Strong adhesive packing tape for sealing cartons and packages securely.',                              'image' => 'products/packing_tape_brown.jpeg'],
            ['name' => 'Zip Lock Bags (100 pcs)',             'category' => 'Packaging Products', 'sub_category' => 'Pouches',    'price' => 95,   'quantity' => 600, 'description' => 'Food-grade zip lock bags in assorted sizes for storage and packaging.',                               'image' => 'products/zip_lock_bags_clear.jpg'],
            ['name' => 'Foam Packing Sheets',                 'category' => 'Packaging Products', 'sub_category' => 'Wrapping',   'price' => 180,  'quantity' => 250, 'description' => 'Soft foam sheets for wrapping and protecting delicate products during transit.',                       'image' => 'products/Foam_packing_sheets.jpg'],

            // ── Corporate Gifting ──
            ['name' => 'Premium Ball Pen Set',                'category' => 'Corporate Gifting',  'sub_category' => 'Stationery', 'price' => 299,  'quantity' => 200, 'description' => 'Set of 5 smooth-writing ball pens in a gift box. Ideal for corporate giveaways.',                    'image' => 'products/Ball_pen.jpg'],
            ['name' => 'Analog Desk Clock',                   'category' => 'Corporate Gifting',  'sub_category' => 'Desk Items', 'price' => 649,  'quantity' => 100, 'description' => 'Elegant analog desk clock with wooden base. A timeless corporate gift.',                               'image' => 'products/analog_clock.jpg'],
            ['name' => 'Leather Notebook A5',                 'category' => 'Corporate Gifting',  'sub_category' => 'Stationery', 'price' => 399,  'quantity' => 150, 'description' => 'Premium faux-leather A5 notebook with 200 ruled pages. Perfect for executives.',                      'image' => 'products/Leather_book.jpg'],
            ['name' => 'USB Flash Drive 32GB',                'category' => 'Corporate Gifting',  'sub_category' => 'Tech',       'price' => 449,  'quantity' => 180, 'description' => 'Branded USB flash drive with 32GB storage. Useful and memorable corporate gift.',                    'image' => 'products/USB.png'],
            ['name' => 'Stainless Steel Water Bottle',        'category' => 'Corporate Gifting',  'sub_category' => 'Drinkware',  'price' => 599,  'quantity' => 120, 'description' => 'Double-walled insulated steel bottle keeping drinks hot or cold for hours.',                          'image' => 'products/Steel_water_bottle.jpg'],
            ['name' => 'Wireless Mouse',                      'category' => 'Corporate Gifting',  'sub_category' => 'Tech',       'price' => 799,  'quantity' => 90,  'description' => 'Ergonomic wireless mouse with silent click. Great tech gift for professionals.',                      'image' => 'products/Wireless_mouse.jpg'],
            ['name' => 'Desk Organiser Set',                  'category' => 'Corporate Gifting',  'sub_category' => 'Desk Items', 'price' => 549,  'quantity' => 110, 'description' => 'Multi-compartment desk organiser for pens, cards, and stationery. Sleek design.',                   'image' => 'products/Desk_org.jpg'],

            // ── Pet Containers ──
            ['name' => 'PET Bottle 500ml (50 pcs)',           'category' => 'Pet Containers',     'sub_category' => 'Bottles',    'price' => 380,  'quantity' => 400, 'description' => 'Clear PET bottles with screw caps. Food-grade and BPA-free. Pack of 50.',                            'image' => 'products/500ml-transparent-pet-plastic-water-bottle.jpg'],
            ['name' => 'PET Jar 250ml (30 pcs)',              'category' => 'Pet Containers',     'sub_category' => 'Jars',       'price' => 290,  'quantity' => 300, 'description' => 'Wide-mouth PET jars ideal for dry foods, spices, and cosmetic products.',                            'image' => 'products/Pet_jar.jpg'],
            ['name' => 'PET Bottle 1 Litre (25 pcs)',         'category' => 'Pet Containers',     'sub_category' => 'Bottles',    'price' => 420,  'quantity' => 250, 'description' => 'Large 1-litre PET bottles suitable for juices, sauces, and liquid products.',                       'image' => 'products/1-litre-pet-bottle-500x500.webp'],
            ['name' => 'Trigger Spray Bottle 750ml',          'category' => 'Pet Containers',     'sub_category' => 'Spray',      'price' => 95,   'quantity' => 350, 'description' => 'Durable PET trigger spray bottle for cleaning products and gardening use.',                          'image' => 'products/spray_bottle.jpg'],
            ['name' => 'Cosmetic Pump Bottle 200ml',          'category' => 'Pet Containers',     'sub_category' => 'Pump',       'price' => 65,   'quantity' => 500, 'description' => 'Elegant PET pump dispenser bottle suitable for lotions, soaps, and serums.',                         'image' => 'products/dispenser_bottle.jpg'],

            // ── Disposables ──
            ['name' => 'Disposable Plates (50 pcs)',          'category' => 'Disposables',        'sub_category' => 'Tableware',  'price' => 140,  'quantity' => 500, 'description' => 'Sturdy disposable plates suitable for events, canteens, and food service.',                           'image' => 'products/disposeable_plates.jpg'],
            ['name' => 'Plastic Cups 200ml (100 pcs)',        'category' => 'Disposables',        'sub_category' => 'Tableware',  'price' => 110,  'quantity' => 600, 'description' => 'Lightweight disposable cups ideal for water, juice, and beverages.',                                 'image' => 'products/disposeable_cups.jpg'],
            ['name' => 'Disposable Spoon & Fork Set',         'category' => 'Disposables',        'sub_category' => 'Cutlery',    'price' => 85,   'quantity' => 700, 'description' => 'Pack of 50 each - disposable plastic spoons and forks for catering use.',                           'image' => 'products/plastic-spoon-and-fork.png'],
            ['name' => 'Aluminium Foil Container',            'category' => 'Disposables',        'sub_category' => 'Food Packs', 'price' => 220,  'quantity' => 400, 'description' => 'Oven-safe aluminium foil containers for takeaway food and meal prep.',                               'image' => 'products/foil_container.avif'],
            ['name' => 'Disposable Gloves (100 pcs)',         'category' => 'Disposables',        'sub_category' => 'Safety',     'price' => 175,  'quantity' => 800, 'description' => 'Powder-free disposable gloves for hygiene and food handling applications.',                          'image' => 'products/disposeable_gloves.jpg'],
            ['name' => 'Paper Bags (50 pcs)',                 'category' => 'Disposables',        'sub_category' => 'Bags',       'price' => 195,  'quantity' => 450, 'description' => 'Eco-friendly kraft paper carry bags with handles. Available in two sizes.',                          'image' => 'products/kraft_paper_bag.jpg'],

            // ── Housekeeping ──
            ['name' => 'Microfibre Cleaning Cloth (5 pcs)',   'category' => 'Housekeeping',       'sub_category' => 'Cleaning',   'price' => 199,  'quantity' => 300, 'description' => 'Ultra-soft microfibre cloths for dust-free cleaning of surfaces and glass.',                         'image' => 'products/Microfibre_cleaning_cloth.jpg'],
            ['name' => 'Mop with Bucket Set',                 'category' => 'Housekeeping',       'sub_category' => 'Cleaning',   'price' => 849,  'quantity' => 80,  'description' => 'Spin mop and bucket combo for efficient floor cleaning in large spaces.',                            'image' => 'products/mop_bucket.jpg'],
            ['name' => 'Industrial Broom',                    'category' => 'Housekeeping',       'sub_category' => 'Sweeping',   'price' => 299,  'quantity' => 120, 'description' => 'Heavy-duty broom with stiff bristles for sweeping hard floors and outdoor areas.',                   'image' => 'products/broom_bristles.jpg'],
            ['name' => 'All-Purpose Cleaner 5L',              'category' => 'Housekeeping',       'sub_category' => 'Chemicals',  'price' => 450,  'quantity' => 200, 'description' => 'Concentrated all-purpose liquid cleaner for floors, tiles, and surfaces.',                           'image' => 'products/10l-multipurpose-liquid-cleaner-500x500.webp'],
            ['name' => 'Garbage Bags (50 pcs)',               'category' => 'Housekeeping',       'sub_category' => 'Waste',      'price' => 160,  'quantity' => 500, 'description' => 'Heavy-duty garbage bags in black. Tear-resistant for office and hotel use.',                         'image' => 'products/grabage_bag.jpg'],
            ['name' => 'Air Freshener Spray 300ml',           'category' => 'Housekeeping',       'sub_category' => 'Fragrance',  'price' => 189,  'quantity' => 250, 'description' => 'Long-lasting air freshener spray for rooms, washrooms, and common areas.',                          'image' => 'products/air_freshner.webp'],

            // ── Hotel Dry Amenities ──
            ['name' => 'Shampoo Sachet (100 pcs)',            'category' => 'Hotel Dry Amenities','sub_category' => 'Hair Care',  'price' => 350,  'quantity' => 600, 'description' => 'Single-use hotel shampoo sachets with mild fragrance. Bulk pack of 100.',                           'image' => 'products/shampoo_sachet.webp'],
            ['name' => 'Conditioner Sachet (100 pcs)',        'category' => 'Hotel Dry Amenities','sub_category' => 'Hair Care',  'price' => 350,  'quantity' => 600, 'description' => 'Hotel-grade conditioner sachets for smooth and manageable hair.',                                   'image' => 'products/conditner_sachet.jpg'],
            ['name' => 'Bath Soap Bar (50 pcs)',              'category' => 'Hotel Dry Amenities','sub_category' => 'Body Care',  'price' => 480,  'quantity' => 400, 'description' => 'Premium hotel soap bars with moisturising formula. Individually wrapped.',                          'image' => 'products/bar_soap.avif'],
            ['name' => 'Shower Cap (50 pcs)',                 'category' => 'Hotel Dry Amenities','sub_category' => 'Accessories','price' => 195,  'quantity' => 700, 'description' => 'Disposable shower caps in polythene. Standard hotel room amenity.',                                 'image' => 'products/shower-cap-for-hotels-423.jpg'],
            ['name' => 'Moisturiser Lotion Sachet (100 pcs)', 'category' => 'Hotel Dry Amenities','sub_category' => 'Body Care',  'price' => 390,  'quantity' => 500, 'description' => 'Single-use body lotion sachets for hotel guest rooms and spa use.',                                'image' => 'products/moist_sachet.jpg'],

            // ── Office Stationery ──
            ['name' => 'A4 Copier Paper (500 sheets)',        'category' => 'Office Stationery',  'sub_category' => 'Paper',      'price' => 299,  'quantity' => 400, 'description' => 'High-quality 75 GSM A4 copy paper for laser and inkjet printers.',                                  'image' => 'products/a4-size-plain-paper.jpg'],
            ['name' => 'Stapler with Pins',                   'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 199,  'quantity' => 150, 'description' => 'Heavy-duty office stapler with a pack of 1000 staple pins included.',                               'image' => 'products/stapler.webp'],
            ['name' => 'Whiteboard Markers (Set of 4)',       'category' => 'Office Stationery',  'sub_category' => 'Markers',    'price' => 149,  'quantity' => 200, 'description' => 'Dry-erase whiteboard markers in 4 colours. Smooth writing, easy to wipe.',                         'image' => 'products/whiteboard_marker.jpg'],
            ['name' => 'Sticky Notes (5 Pads)',               'category' => 'Office Stationery',  'sub_category' => 'Paper',      'price' => 129,  'quantity' => 300, 'description' => 'Bright coloured sticky note pads for reminders and quick messages.',                               'image' => 'products/sticky_notes.jpg'],
            ['name' => 'Scissors (Pack of 2)',                'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 119,  'quantity' => 180, 'description' => 'Sharp stainless steel office scissors with comfortable grip handles.',                              'image' => 'products/scissors.jpg'],
            ['name' => 'File Folders (Pack of 10)',           'category' => 'Office Stationery',  'sub_category' => 'Filing',     'price' => 175,  'quantity' => 250, 'description' => 'Durable A4 file folders for organising documents and reports.',                                    'image' => 'products/file_folder.jpg'],
            ['name' => 'Correction Pen',                      'category' => 'Office Stationery',  'sub_category' => 'Tools',      'price' => 49,   'quantity' => 400, 'description' => 'Quick-drying correction fluid pen for neat error correction on paper.',                             'image' => 'products/correction_pen.jpg'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name'         => $product['name'],
                'category'     => $product['category'],
                'sub_category' => $product['sub_category'],
                'price'        => $product['price'],
                'quantity'     => $product['quantity'],
                'description'  => $product['description'],
                'image_path'   => $product['image'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
