<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    public static function getGcashQrUrl(): string
    {
        return self::query()->where('key', 'gcash_qr')->first()->value;
    }

    public static function setGcashQrUrl(string $value): void
    {
        self::query()->where('key', 'gcash_qr')->update(['value' => $value]);
    }
}
