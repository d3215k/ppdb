<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JarakRumah: int implements HasLabel
{
    case KURANG_SATU_KILO = 0;
    case LEBIH_SATU_KILO = 1;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KURANG_SATU_KILO => 'Kurang dari 1 km',
            self::LEBIH_SATU_KILO => 'Lebih dari 1 km',
        };
    }
}
