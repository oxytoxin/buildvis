<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected static function booted(): void
    {
        static::updated(function (Customer $customer) {
            $customer->user()->update([
                'name' => $customer->name,
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
