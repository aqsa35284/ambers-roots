<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Retrieve a setting by key with fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            $value = Cache::remember("setting.{$key}", 3600, function () use ($key) {
                return self::where('key', $key)->value('value');
            });

            return $value !== null ? $value : $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Set/update a setting by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string)$value,
                'group' => $group,
            ]
        );

        Cache::forget("setting.{$key}");

        return $setting;
    }
}

