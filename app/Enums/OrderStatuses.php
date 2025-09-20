<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatuses: int implements HasColor, HasLabel
{
    case CART = 1;
    case PENDING = 2;
    case PROCESSING = 3;
    case SHIPPED = 4;
    case DELIVERED = 5;
    case CANCELLED = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CART => 'Cart',
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CART => 'gray',
            self::PENDING, self::PROCESSING => 'warning',
            self::SHIPPED, self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
