<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UkuranBaju: string implements HasLabel
{
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';
    case _3XL = '3XL';
    case _4XL = '3XL';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::S => 'S',
            self::M => 'M',
            self::L => 'L',
            self::XL => 'XL',
            self::XXL => 'XXL',
            self::_3XL => '3XL',
            self::_4XL => '4XL',
        };
    }
}
