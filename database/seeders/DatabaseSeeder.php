<?php

namespace Database\Seeders;

use App\Models\LivestockListing;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\HadpApplication;
use App\Models\InaphPassport;
use App\Models\BahakTransitLog;
use App\Models\WoolLabRecord;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@kashmirsheeps.gov.in'],
            [
                'name' => 'Dr. Farooq Mir (Director Sheep Husbandry)',
                'password' => bcrypt('kashmir@sheep1962'),
            ]
        );

        // 1. Livestock Listings
        $listings = [
            [
                'type' => 'live',
                'category' => 'hadp',
                'title_en' => 'SKUAST-K Certified Elite Kashmir Merino Breeding Ram',
                'title_ur' => 'اسکاسٹ تصدیق شدہ کشمیری میرینو بریڈنگ مینڈھ',
                'price' => 38000.00,
                'weight' => '68 Kg',
                'spec_en' => '2 Teeth (Doda) • 20.5 Micron Superfine Fleece',
                'spec_ur' => '۲ دانت (دودا) • ۲۰.۵ مائکرون ریشمی اون',
                'district' => 'Ganderbal',
                'village_en' => 'SKUAST-K Mountain Livestock Research Center, Mansbal',
                'village_ur' => 'مانسبل اسکاسٹ ریسرچ سینٹر',
                'farmer_name' => 'SKUAST-Kashmir Genetics Division',
                'phone' => '+91-94190-24810',
                'whatsapp' => '919419024810',
                'is_qurbani' => true,
                'verified' => true,
                'rating' => 5.0,
                'reviews_count' => 14,
                'inaph_tag' => '040029481023',
                'is_sold' => false,
                'desc_en' => 'Govt certified pure Kashmir Merino ram bred for high-altitude disease resilience, superior twin-lambing lineage, and 19-21 micron apparel-grade wool. Fully ETV and Sheep Pox immunized under SKUAST-K protocol.',
                'desc_ur' => 'حکومتی تصدیق شدہ خالص کشمیری میرینو مینڈھ۔ شدید سردی برداشت کرنے والا اعلیٰ نسل اور ۲۰ مائکرون اون پیدا کرنے کی صلاحیت۔ مکمل ویکسین شدہ۔',
                'sire_line' => 'SKUAST-K Sire Elite Line 88',
                'dam_line' => 'Mansbal Pure Merino Dam 104',
                'gallery' => [
                    'https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1484557052118-f32bd25b45b5?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'live',
                'category' => 'merino',
                'title_en' => 'Pure Kashmir Merino Stud Ram (Champion Line)',
                'title_ur' => 'خالص کشمیری میرینو نر مینڈھ (چیمپین نسل)',
                'price' => 32000.00,
                'weight' => '62 Kg',
                'spec_en' => '2 Teeth (Doda) • Heavy Curl Horns',
                'spec_ur' => '۲ دانت (دودا) • گھنگریالے سینگ',
                'district' => 'Anantnag',
                'village_en' => 'Mattan Highland Farm',
                'village_ur' => 'مٹن، اننت ناگ',
                'farmer_name' => 'Ghulam Rasool Mir',
                'phone' => '+91-94190-11223',
                'whatsapp' => '919419011223',
                'is_qurbani' => true,
                'verified' => true,
                'rating' => 4.9,
                'reviews_count' => 8,
                'inaph_tag' => '040038192044',
                'is_sold' => false,
                'desc_en' => 'Healthy grazing Kashmir Merino ram. Clean white coat, verified 2 teeth, ideal for farm improvement and Eid Qurbani. Vet health card issued by VAS Mattan.',
                'desc_ur' => 'صحت مند چرنے والا کشمیری میرینو مینڈھ۔ صاف سفید رنگت، دو دانت، قربانی اور فارم بریڈنگ کیلئے موزوں۔',
                'sire_line' => 'Daksum Forest Ram #12',
                'dam_line' => 'Mattan Merino #09',
                'gallery' => [
                    'https://images.unsplash.com/photo-1526030994690-40e26ad32a1c?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'live',
                'category' => 'bakarwali',
                'title_en' => 'Pir Panjal Bakarwali Mountain Ram (Highland Adapted)',
                'title_ur' => 'پیر پنجال بکروال پہاڑی مینڈھ',
                'price' => 28500.00,
                'weight' => '58 Kg',
                'spec_en' => '4 Teeth • Long Drooping Ears • Robust Stature',
                'spec_ur' => '۴ دانت • لمبے لٹکتے کان • انتہائی طاقتور',
                'district' => 'Shopian',
                'village_en' => 'Hirpora Alpine Foothills',
                'village_ur' => 'ہیرپورہ، شوپیاں',
                'farmer_name' => 'Mohd Ashraf Khatana',
                'phone' => '+91-99060-44556',
                'whatsapp' => '919906044556',
                'is_qurbani' => true,
                'verified' => true,
                'rating' => 4.8,
                'reviews_count' => 6,
                'inaph_tag' => '040078192019',
                'is_sold' => false,
                'desc_en' => 'Hardy mountain breed adapted to Pir Panjal passes. Exceptional muscle growth on wild alpine pasture grazing, lean mutton conformation.',
                'desc_ur' => 'پہاڑی علاقوں کیلئے سخت جان نسل۔ پہاڑی گھاس پر پلا ہوا خالص گوشت کا مینڈھ۔',
                'sire_line' => 'Peer Ki Gali Wild Ram',
                'dam_line' => 'Hirpora Mountain Ewe',
                'gallery' => [
                    'https://images.unsplash.com/photo-1484557052118-f32bd25b45b5?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'live',
                'category' => 'qurbani',
                'title_en' => 'Premium Eid Qurbani Fat-Tail Dumba Cross Ram',
                'title_ur' => 'اعلیٰ عید قربانی دنبہ کراس مینڈھ',
                'price' => 42000.00,
                'weight' => '72 Kg',
                'spec_en' => '2 Teeth (Doda) • Defect-Free Sharia Compliant',
                'spec_ur' => '۲ دانت (دودا) • بے عیب و شرعی شرائط کے مطابق',
                'district' => 'Pulwama',
                'village_en' => 'Tral Valley Mandi',
                'village_ur' => 'ترال ویلی، پلوامہ',
                'farmer_name' => 'Tariq Ahmad Wani',
                'phone' => '+91-94194-77889',
                'whatsapp' => '919419477889',
                'is_qurbani' => true,
                'verified' => true,
                'rating' => 5.0,
                'reviews_count' => 12,
                'inaph_tag' => '040058291033',
                'is_sold' => false,
                'desc_en' => 'Flawless Qurbani animal: intact horns, flawless ears and teeth, fed on clover grass, barley grain and SKUAST silage ration. Ready for doorstep delivery.',
                'desc_ur' => 'قربانی کے تمام شرعی معیارات پر پورا اترنے والا صحت مند اور فربہ مینڈھ۔',
                'sire_line' => 'Tral Fat-tail Sire',
                'dam_line' => 'Aripal Ewe',
                'gallery' => [
                    'https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'product',
                'category' => 'fertilizer',
                'title_en' => 'Fermented Organic Sheep Manure (Tractor Trolley - 500 Kg)',
                'title_ur' => 'خالص بھیڑ کی دیسی کھاد (ٹریکٹر ٹرالی - ۵۰۰ کلو)',
                'price' => 4500.00,
                'weight' => '500 Kg',
                'spec_en' => 'High Nitrogen-Potash for Apple Orchards',
                'spec_ur' => 'سیب کے باغات کیلئے اعلیٰ نائٹروجن و پوٹاشیم',
                'district' => 'Baramulla',
                'village_en' => 'Sopore Apple Belt',
                'village_ur' => 'سوپور، بارہمولہ',
                'farmer_name' => 'Haji Sanaullah',
                'phone' => '+91-97970-33441',
                'whatsapp' => '919797033441',
                'is_qurbani' => false,
                'verified' => true,
                'rating' => 4.9,
                'reviews_count' => 29,
                'is_sold' => false,
                'desc_en' => 'Aged and decomposed sheep droppings collected from highland night sheds. Provides steady organic warmth to apple tree rootzones during Kashmir winters.',
                'desc_ur' => 'ہائی آلٹیچیوڈ کی رات کے باڑوں سے جمع شدہ سڑی ہوئی دیسی کھاد۔ سیب کے درختوں کی جڑوں کیلئے بہترین گرمائش۔',
                'gallery' => [
                    'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'product',
                'category' => 'supplies',
                'title_en' => 'SKUAST-K Urea Molasses Mineral Block (UMMB) - 5 Kg Lick',
                'title_ur' => 'اسکاسٹ یوریا ملاسز منرل بلاک (سالٹ لک - ۵ کلو)',
                'price' => 380.00,
                'weight' => '5 Kg',
                'spec_en' => 'Chillai Kalan Essential Winter Mineral Ruminant Supplement',
                'spec_ur' => 'چلہ کلاں کے شدید موسم میں جانوروں کیلئے معدنی ٹانک',
                'district' => 'Srinagar',
                'village_en' => 'Animal Nutrition Division, SKUAST-K',
                'village_ur' => 'شالیمار، سری نگر',
                'farmer_name' => 'SKUAST-Kashmir Agro Extension',
                'phone' => '+91-94190-88112',
                'whatsapp' => '919419088112',
                'is_qurbani' => false,
                'verified' => true,
                'rating' => 4.9,
                'reviews_count' => 41,
                'is_sold' => false,
                'desc_en' => 'Scientifically formulated lick block containing non-protein nitrogen, sulfur, zinc, copper, and bypass vitamins to maintain rumen flora during sub-zero stall feeding.',
                'desc_ur' => 'اسکاسٹ کے سائنسدانوں کا تیار کردہ منرل سالٹ لک جو منفی درجہ حرارت میں بھیڑ کی بھوک اور ہاضمہ بحال رکھتا ہے۔',
                'gallery' => [
                    'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'product',
                'category' => 'wool',
                'title_en' => 'SKUAST-K Graded Kashmir Merino Raw Fleece Wool (4 Kg Braid)',
                'title_ur' => 'اسکاسٹ گریڈڈ کشمیری میرینو خام اون (۴ کلو)',
                'price' => 1650.00,
                'weight' => '4 Kg',
                'spec_en' => 'HADP Project 27 Certified • 20.2 Micron Staple',
                'spec_ur' => 'پروجیکٹ ۲۷ سرٹیفائیڈ • ۲۰.۲ مائکرون ریشہ',
                'district' => 'Budgam',
                'village_en' => 'Charar-i-Sharief Sheep Extension',
                'village_ur' => 'چرار شریف، بڈگام',
                'farmer_name' => 'Chopan Development Board',
                'phone' => '+91-94190-55221',
                'whatsapp' => '919419055221',
                'is_qurbani' => false,
                'verified' => true,
                'rating' => 4.8,
                'reviews_count' => 19,
                'is_sold' => false,
                'desc_en' => 'Hand-sheared and skirted pure Kashmir Merino fleece. Clean fleece yield ~64%, suitable for hand-knitting Pheran yarn, shawls, and tweed weaving.',
                'desc_ur' => 'ہاتھ سے کتری ہوئی صاف سفید کشمیری میرینو اون۔ روایتی فیرن، شال اور لنگیر بنانے کیلئے اعلیٰ ترین خام مال۔',
                'gallery' => [
                    'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'type' => 'product',
                'category' => 'supplies',
                'title_en' => 'Professional 650W Sheep Electric Shearing Clipper Machine',
                'title_ur' => '۶۵۰ واٹ الیکٹرک بھیڑ کترنے والی مشین (کلپر)',
                'price' => 6400.00,
                'weight' => '3.2 Kg',
                'spec_en' => 'HADP Project 27 Approved • 6-Speed Copper Motor',
                'spec_ur' => 'پروجیکٹ ۲۷ منظور شدہ • ۶ اسپیڈ کاپر موٹر',
                'district' => 'Srinagar',
                'village_en' => 'Batamaloo Mandi Equipment Center',
                'village_ur' => 'بٹہ مالو، سری نگر',
                'farmer_name' => 'Kashmir Agri & Sheep Tools',
                'phone' => '+91-94190-33219',
                'whatsapp' => '919419033219',
                'is_qurbani' => false,
                'verified' => true,
                'rating' => 4.9,
                'reviews_count' => 33,
                'is_sold' => false,
                'desc_en' => 'Heavy duty 650W rotary motor shearing clippers with Beiyuan-compatible curved 13-tooth comb and 4-point cutter. Cuts 30-40 sheep per day without overheating.',
                'desc_ur' => 'جدید الیکٹرک شیئرنگ مشین۔ روزانہ ۳۰ سے ۴۰ بھیڑوں کی کٹائی کے قابل۔ ۱۰ منٹ میں بغیر زخم لگائے اون اتارتی ہے۔',
                'gallery' => [
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80'
                ]
            ]
        ];

        foreach ($listings as $l) {
            $created = LivestockListing::create($l);

            // If it has an INAPH tag, create the passport
            if (!empty($l['inaph_tag'])) {
                InaphPassport::create([
                    'tag_no' => $l['inaph_tag'],
                    'livestock_listing_id' => $created->id,
                    'breed' => $l['title_en'],
                    'genotype' => 'Kashmir Merino (87.5% Rambouillet x Gaddi Cross)',
                    'sex' => 'Ram / Male',
                    'dob' => '2024-04-12',
                    'teeth' => $l['spec_en'],
                    'sire_line' => $l['sire_line'] ?? 'SKUAST-K Lineage',
                    'dam_line' => $l['dam_line'] ?? 'Govt Sheep Farm Dachigam',
                    'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
                    'etv_vaccination_date' => '2026-08-15',
                    'pox_vaccination_date' => '2026-07-20',
                    'ppr_vaccination_date' => '2025-05-10',
                    'fmd_vaccination_date' => '2026-09-01',
                    'deworming_date' => '2026-10-10',
                    'deworming_drug' => 'Fenbendazole 10% (SKUAST Protocol)',
                    'vet_officer' => 'Dr. M. A. Lone, VAS J&K Sheep Husbandry',
                    'fitness_cert_no' => 'JK-VET-FIT-2026-' . rand(100, 999),
                    'owner_name' => $l['farmer_name'],
                    'district' => $l['district'],
                ]);
            }
        }

        // 2. Pre-seeded Orders
        $order1 = Order::create([
            'order_no' => 'KS-891042',
            'customer_name' => 'Tariq Ahmad Mir',
            'customer_phone' => '09419024810',
            'district' => 'Anantnag',
            'delivery_address' => 'Near Jamia Masjid, Mattan, Anantnag - 192125',
            'pin_code' => '192125',
            'payment_method' => 'Cash on Delivery',
            'payment_status' => 'pending',
            'subtotal' => 38000.00,
            'shipping_fee' => 0.00,
            'total_amount' => 38000.00,
            'status' => 'In Transit',
            'carrier_vehicle' => 'JK01-AH-4912 (J&K Livestock Express)',
            'vas_officer_cleared' => 'Dr. Rafiq Ahmad, VAS Ganderbal',
            'notes' => 'Handle with care; breeding ram for high-altitude orchard farm.',
            'created_at' => now()->subHours(18),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'title' => 'SKUAST-K Certified Elite Kashmir Merino Breeding Ram',
            'spec' => '2 Teeth (Doda) • 20.5 Micron Superfine',
            'inaph_tag' => '040029481023',
            'unit_price' => 38000.00,
            'quantity' => 1,
            'total_price' => 38000.00,
        ]);

        $order2 = Order::create([
            'order_no' => 'KS-672109',
            'customer_name' => 'Farooq Ahmad Lone',
            'customer_phone' => '09797033441',
            'district' => 'Baramulla',
            'delivery_address' => 'Main Chowk, Model Apple Orchard, Sopore - 193201',
            'pin_code' => '193201',
            'payment_method' => 'Instant UPI',
            'payment_status' => 'verified',
            'upi_reference' => 'UPI902481092812',
            'subtotal' => 4500.00,
            'shipping_fee' => 0.00,
            'total_amount' => 4500.00,
            'status' => 'Delivered',
            'carrier_vehicle' => 'JK05-B-1190 Tractor Trolley',
            'vas_officer_cleared' => 'Not Applicable (Organic Produce)',
            'notes' => 'Direct unload at tree beds.',
            'created_at' => now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'title' => 'Fermented Organic Sheep Manure (Tractor Trolley - 500 Kg)',
            'spec' => 'High Nitrogen-Potash for Apple Orchards',
            'unit_price' => 4500.00,
            'quantity' => 1,
            'total_price' => 4500.00,
        ]);

        // 3. Pre-seeded HADP Applications
        HadpApplication::create([
            'ref_no' => 'HADP-JK-SHP-84920',
            'beneficiary_name' => 'Ghulam Hassan Wani',
            'aadhaar_hash' => 'XXXX-XXXX-7182',
            'phone' => '09419477889',
            'district' => 'Pulwama',
            'target_scheme' => 'Project 24: Commercial 50-Ewe Sheep Farm (50% DBT)',
            'training_status' => 'Certified - Daksh Kisan SKUAST-K Level 2',
            'unit_cost' => 500000.00,
            'subsidy_amount' => 250000.00,
            'workflow_stage' => 3, // VAS Field Inspection Cleared
            'kkg_center_id' => 'KKG-PUL-TRAL-02',
            'vas_inspector_name' => 'Dr. Z. A. Rather, VAS Tral',
            'sanction_order_no' => 'DSHO/PUL/HADP-24/2026/419',
        ]);

        HadpApplication::create([
            'ref_no' => 'HADP-JK-SHP-62104',
            'beneficiary_name' => 'Showkat Ahmad Bhat',
            'aadhaar_hash' => 'XXXX-XXXX-4911',
            'phone' => '09906044556',
            'district' => 'Shopian',
            'target_scheme' => 'Project 27: Modern Shearing Unit & Wool Scouring (50% DBT)',
            'training_status' => 'Enrolled in Daksh Kisan LMS',
            'unit_cost' => 300000.00,
            'subsidy_amount' => 150000.00,
            'workflow_stage' => 1, // KKG Intake Form Submitted
            'kkg_center_id' => 'KKG-SHP-HIR-01',
        ]);

        // 4. Pre-seeded Bahak Transit Logs
        BahakTransitLog::create([
            'permit_no' => 'BAHAK-JK-2026-9041',
            'chopan_name' => 'Bashir Ahmad Tedwa',
            'chopan_id' => 'CHP-KST-092',
            'phone' => '09419011223',
            'route_name' => 'Sinthan Top Pass (Kishtwar to Daksum Corridor)',
            'ewe_count' => 260,
            'ram_count' => 30,
            'lamb_count' => 130,
            'total_head_count' => 420,
            'dipping_cert_no' => 'DIP-DAKSUM-2026-081',
            'checkpost_name' => 'Daksum Checkpost',
            'transit_date' => '2026-10-18',
            'clearance_status' => 'Cleared',
        ]);

        BahakTransitLog::create([
            'permit_no' => 'BAHAK-JK-2026-7812',
            'chopan_name' => 'Ghulam Rasool Poswal',
            'chopan_id' => 'CHP-BND-044',
            'phone' => '09419024810',
            'route_name' => 'Gurez - Tulail Pass',
            'ewe_count' => 380,
            'ram_count' => 45,
            'lamb_count' => 225,
            'total_head_count' => 650,
            'dipping_cert_no' => 'DIP-DAWAR-2026-114',
            'checkpost_name' => 'Dawar Alpine Post',
            'transit_date' => '2026-10-22',
            'clearance_status' => 'Cleared',
        ]);

        // 5. Pre-seeded Wool Lab Testing Record
        WoolLabRecord::create([
            'sample_code' => 'WOOL-SKUAST-2026-891',
            'farmer_name' => 'Ghulam Rasool Mir',
            'flock_tag_reference' => 'TAG-040038192044',
            'district' => 'Anantnag',
            'micron' => 19.2,
            'staple_length_cm' => 7.8,
            'clean_yield_pct' => 65.4,
            'greasy_weight_kg' => 3.80,
            'wool_grade' => 'Superfine Merino Grade A',
            'msp_rate_per_kg' => 340.00,
            'clean_yield_bonus' => 95.00,
            'total_payout' => 1653.00,
            'certified_by' => 'SKUAST-K Wool Testing & Quality Certification Division',
        ]);
    }
}
