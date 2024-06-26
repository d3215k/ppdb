<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel, HasColor
{
    case PENDAFTAR = 1;
    case PENGUJI = 2;
    case PANITIA = 3;
    case SURVEYOR = 4;
    case ADMIN = 9;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDAFTAR => 'Pendaftar',
            self::PENGUJI => 'Penguji',
            self::PANITIA => 'Panitia',
            self::SURVEYOR => 'Surveyor',
            self::ADMIN => 'Admin',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDAFTAR => 'success',
            self::PENGUJI => 'warning',
            self::PANITIA => 'info',
            self::SURVEYOR => 'warning',
            self::ADMIN => 'danger',
        };
    }
}
