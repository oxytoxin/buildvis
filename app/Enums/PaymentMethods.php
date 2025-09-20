<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethods: int implements HasLabel
{
    case CASH_ON_DELIVERY = 1;
    case GCASH = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CASH_ON_DELIVERY => 'Cash on Delivery',
            self::GCASH => 'GCash',
        };
    }
}
