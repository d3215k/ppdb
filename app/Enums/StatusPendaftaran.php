<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusPendaftaran: int implements HasLabel, HasColor
{
    case PENDAFTARAN = 1;
    //

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDAFTARAN => 'Pendaftaran',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDAFTARAN => 'success',
        };
    }
}
