<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel, HasColor
{
    case CALON_PESERTA_DIDIK = 1;
    case PENGUJI = 2;
    case PANITIA = 3;
    case ADMIN = 9;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CALON_PESERTA_DIDIK => 'Calon Peserta Didik',
            self::PENGUJI => 'Penguji',
            self::PANITIA => 'Panitia',
            self::ADMIN => 'Admin',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CALON_PESERTA_DIDIK => 'success',
            self::PENGUJI => 'warning',
            self::PANITIA => 'info',
            self::ADMIN => 'danger',
        };
    }
}
