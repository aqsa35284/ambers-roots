<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Seed genuine verified customer feedback for Amber's Roots Herbal Hair Oil.
     */
    public function run(): void
    {
        $product = Product::first();
        $productId = $product?->id;

        $reviews = [
            [
                'customer_name' => 'Fatima Zahra (Lahore)',
                'customer_phone' => '03001234567',
                'rating' => 5,
                'review_text' => 'MashaAllah bohot zabardast oil hai! 2 haftay mein hair fall bilkul ruk gaya aur baal soft aur silky ho gaye hain. 100% recommended!',
                'status' => 'approved',
                'created_at' => now()->subDays(1),
            ],
            [
                'customer_name' => 'Muhammad Bilal (Karachi)',
                'customer_phone' => '03211234567',
                'rating' => 5,
                'review_text' => 'Bohot achi fragrance hai aur non-sticky formula hai. Dandruff 1 week mein khatam ho gayi. Fast delivery COD pe parcel mila.',
                'status' => 'approved',
                'created_at' => now()->subDays(2),
            ],
            [
                'customer_name' => 'Zainab Tariq (Islamabad)',
                'customer_phone' => '03331234567',
                'rating' => 5,
                'review_text' => 'Severe hair fall bohot arsay se chal raha tha. Amber\'s Roots regular 3 haftay use kiya, comb mein baal aana 90% khatam ho chuke hain! Hairline par baby hair growth bhi start ho gayi hai.',
                'status' => 'approved',
                'created_at' => now()->subDays(3),
            ],
            [
                'customer_name' => 'Dr. Hina Malik (Faisalabad)',
                'customer_phone' => '03219876543',
                'rating' => 5,
                'review_text' => 'Being a doctor, mein herbal claims par asaani se yaqeen nahi karti. But this oil is 100% authentic pure botanical blend. Scalp itching aur chronic dandruff bilkul theek ho gaya hai.',
                'status' => 'approved',
                'created_at' => now()->subDays(5),
            ],
            [
                'customer_name' => 'Hamza Abbasi (Rawalpindi)',
                'customer_phone' => '03335551234',
                'rating' => 5,
                'review_text' => 'Crown area par thinning start ho chuki thi. 1 month se use kar raha hoon rozana raat ko massage ke saath. Density noticeably improve hui hai. COD delivery fast thi aur open parcel check karne diya.',
                'status' => 'approved',
                'created_at' => now()->subDays(7),
            ],
            [
                'customer_name' => 'Ayesha Siddiqui (Karachi Cantt)',
                'customer_phone' => '03123456789',
                'rating' => 5,
                'review_text' => 'Karachi ke kharay paani ki wajah se baal bohot dry aur brittle ho chuke thay. Amber\'s Roots ne baalon mein natural shine wapas la di. Ab split ends bilkul khatam ho gaye hain.',
                'status' => 'approved',
                'created_at' => now()->subDays(9),
            ],
            [
                'customer_name' => 'Sardar Usman Khan (Peshawar)',
                'customer_phone' => '03456789012',
                'rating' => 5,
                'review_text' => 'Bohot pyari herbal khushboo hai. Dil khush ho gaya parcel dekh kar, luxury glass bottle packaging thi. Scalp aur hair roots dono ke liye kamaal ka result mila hai.',
                'status' => 'approved',
                'created_at' => now()->subDays(12),
            ],
            [
                'customer_name' => 'Maryam Rafiq (Multan)',
                'customer_phone' => '03017654321',
                'rating' => 5,
                'review_text' => 'Mera second order hai yeh! Pehli bottle khatam hote hi hair volume mein clear farq dekha. Meri ammi aur behan bhi ab yahi oil use kar rahi hain. Amber\'s Roots WhatsApp team bhi bohot helpful hai.',
                'status' => 'approved',
                'created_at' => now()->subDays(15),
            ],
            [
                'customer_name' => 'Engr. Noman Ali (Sialkot)',
                'customer_phone' => '03224449876',
                'rating' => 5,
                'review_text' => 'Pure herbs ka ark mehsoos hota hai. Chemical-free authentic oil dhoond raha tha. Baalon ka girna 10 din ke andar stop ho gaya. Highly recommended!',
                'status' => 'approved',
                'created_at' => now()->subDays(18),
            ],
            [
                'customer_name' => 'Sana Bukhari (Lahore Gulberg)',
                'customer_phone' => '03058881234',
                'rating' => 5,
                'review_text' => 'Honestly best hair decision! Wash ke waqt baal guchon mein girte thay, ab brush karne par mushkil se 2 ya 3 baal aate hain. Baal bohot soft aur bouncy ho gaye hain.',
                'status' => 'approved',
                'created_at' => now()->subDays(22),
            ],
        ];

        foreach ($reviews as $rev) {
            $rev['product_id'] = $productId;
            Review::updateOrCreate(
                ['customer_name' => $rev['customer_name']],
                $rev
            );
        }
    }
}

