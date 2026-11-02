<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\WithoutIncrementing;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/** Key/value store settings, edited in Admin › Settings. */
#[Guarded([])]
#[WithoutTimestamps]
#[WithoutIncrementing]
class Setting extends Model
{
    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public const DEFAULTS = [
        'store_name' => 'Mighty Silks',
        'contact_email' => 'info@mightysilks.ae',
        'contact_phone' => '+971 54 586 4310',
        'free_shipping_from' => '1999',
        'standard_shipping' => '99',
        'express_shipping' => '250',
        'order_notify_email' => '',
    ];

    public static function get(string $key): ?string
    {
        $all = Cache::rememberForever('settings', fn () => static::pluck('value', 'key')->all());

        return $all[$key] ?? self::DEFAULTS[$key] ?? null;
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('settings');
    }

    /** Shipping rules shared by checkout (js/main.js) and the order API. */
    public static function shipping(): array
    {
        return [
            'freeFrom' => (float) static::get('free_shipping_from'),
            'standard' => (float) static::get('standard_shipping'),
            'express' => (float) static::get('express_shipping'),
        ];
    }
}
