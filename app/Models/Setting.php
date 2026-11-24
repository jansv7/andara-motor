<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $value = self::query()->where('key', $key)->value('value');

        return $value !== null && $value !== '' ? $value : $default;
    }

    /**
     * @return array<string, string>
     */
    public static function storeProfile(): array
    {
        $defaults = [
            'store_name' => 'Andara Motor',
            'store_tagline' => 'Showroom Motor Bekas Berkualitas, Surat Lengkap & Transparan',
            'store_address' => 'Jl. Kaliurang, Sleman, Yogyakarta',
            'whatsapp_number' => '6281234567890',
            'opening_hours' => 'Senin - Sabtu, 08:30 - 17:30 WIB',
            'instagram_url' => '',
            'facebook_url' => '',
            'tiktok_url' => '',
        ];

        $stored = self::query()->pluck('value', 'key')->all();

        return array_merge($defaults, array_filter($stored, static fn ($v): bool => $v !== null && $v !== ''));
    }
}