<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Admin creates employees, products, and receives real customer orders.
     */
    public function run(): void
    {
        // 1. Create / Update Primary Administrator
        User::updateOrCreate(
            ['email' => 'admin@rivaaj.com'],
            [
                'name' => "Amber's Roots Admin",
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'designation' => 'Executive Director',
                'department' => 'Store Operations',
                'phone' => '+92 327 2222180',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'last_active_at' => now(),
            ]
        );

        // 2. Seed Essential System & Store Settings
        $defaultSettings = [
            'whatsapp_number' => ['value' => '923272222180', 'group' => 'whatsapp'],
            'whatsapp_template' => [
                'value' => "🌿 *New Order - Amber's Roots Herbal Care*\n──────────────────────\n📦 *Order:* #{order_number}\n👤 *Customer:* {customer_name}\n📞 *Phone:* {customer_phone}\n📍 *Address:* {shipping_address}, {city}\n──────────────────────\n🛒 *Items:*\n{items}\n──────────────────────\n💰 *Total Amount:* Rs. {total}\n🚚 *Shipping:* Free Doorstep Delivery\n💳 *Payment Method:* Cash on Delivery (COD)\n\nPlease confirm my order and share dispatch tracking!",
                'group' => 'whatsapp'
            ],
            'whatsapp_auto_open' => ['value' => '1', 'group' => 'whatsapp'],
            'store_name' => ['value' => "Amber's Roots", 'group' => 'website'],
            'store_tagline' => ['value' => 'Pure Herbs, Pure Results', 'group' => 'website'],
            'store_phone' => ['value' => '+92 327 2222180', 'group' => 'website'],
            'store_email' => ['value' => 'info@ambersroots.com', 'group' => 'website'],
            'store_address' => ['value' => 'Big City Plaza Laboratory', 'group' => 'website'],
            'announcement_text' => ['value' => 'Trusted by 50,000+ happy customers across Pakistan • 4.9★ rating • Free Doorstep Express Delivery', 'group' => 'website'],
            'free_shipping_min' => ['value' => '0', 'group' => 'website'],
        ];

        foreach ($defaultSettings as $key => $sData) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $sData['value'], 'group' => $sData['group']]
            );
        }
    }
}
