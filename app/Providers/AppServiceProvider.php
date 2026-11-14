<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

if (!function_exists('getSetting')) {
    function getSetting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $waNum = Setting::get('whatsapp_number', '923272222180');
            $cleanWa = preg_replace('/[^0-9]/', '', (string)$waNum);
            $cleanWa = ltrim($cleanWa, '+');
            if (str_starts_with($cleanWa, '0')) {
                $cleanWa = '92' . substr($cleanWa, 1);
            }

            $view->with([
                'whatsappNumber' => $cleanWa ?: '923272222180',
                'announcementText' => Setting::get('announcement_text', 'Trusted by 50,000+ customers across Pakistan • 4.9★ rating • Free Express Shipping'),
                'storePhone' => Setting::get('store_phone', '+92 327 2222180'),
                'storeEmail' => Setting::get('store_email', 'info@ambersroots.com'),
                'storeName' => Setting::get('store_name', "Amber's Roots"),
                'storeAddress' => Setting::get('store_address', 'Big City Plaza Laboratory'),
            ]);
        });
    }
}
