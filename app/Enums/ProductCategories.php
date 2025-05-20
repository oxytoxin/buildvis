<?php

namespace App\Enums;

enum ProductCategories: int
{
    case Electrical = 1;
    case Paintings = 2;
    case Plumbing = 3;
    case Steel = 4;
    case Others = 5;

    public function label(): string
    {
        return match ($this) {
            self::Electrical => 'Electrical',
            self::Paintings => 'Paintings',
            self::Plumbing => 'Plumbing',
            self::Steel => 'Steel',
            self::Others => 'Others',
        };
    }
}
