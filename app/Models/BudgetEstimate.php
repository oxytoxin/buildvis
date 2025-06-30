<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetEstimate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'structured_data' => 'array',
        'house_data' => 'array',
        'total_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetEstimateItem::class);
    }

    public static function booted()
    {
        static::creating(function ($estimate) {
            $estimate->status ??= 'draft';
            $estimate->total_amount ??= 0;
        });
    }

    /**
     * Update the total amount based on items
     */
    public function updateTotalAmount(): void
    {
        $this->updateQuietly([
            'total_amount' => $this->items()->sum('subtotal')
        ]);
    }
}
