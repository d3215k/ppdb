<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserType: int implements HasLabel, HasColor
{
    case CALON_PESERTA_DIDIK = 1;
    case ADVISOR = 2;
    case ADMIN = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CALON_PESERTA_DIDIK => 'Calon Peserta Didik',
            self::ADVISOR => 'ADVISOR',
            self::ADMIN => 'Admin',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CALON_PESERTA_DIDIK => 'success',
            self::ADVISOR => 'warning',
            self::ADMIN => 'danger',
        };
    }
}
