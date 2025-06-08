<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetEstimateItem extends Model
{
    use HasFactory;

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];


    public function budget_estimate(): BelongsTo
    {
        return $this->belongsTo(BudgetEstimate::class);
    }

    public function work_category(): BelongsTo
    {
        return $this->belongsTo(WorkCategory::class);
    }

    public function product_variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
