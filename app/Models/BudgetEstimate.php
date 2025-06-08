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
        'total_amount' => 'decimal:2',
    ];

    protected $fillable = [
        'customer_id',
        'name',
        'description',
        'structured_data',
        'total_amount',
        'status',
        'notes',
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

        // Update total amount when items are modified
        static::updated(function ($estimate) {
            $estimate->update([
                'total_amount' => $estimate->items()->sum('subtotal')
            ]);
        });
    }
}
