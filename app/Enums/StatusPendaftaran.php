<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPendaftaran: int implements HasLabel, HasColor, HasIcon
{
    case PENDAFTARAN = 1;
    case MENUNGGU = 5;
    case LULUS = 6;
    case TIDAK_LULUS = 7;
    case MENGUNDURKAN_DIRI = 8;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDAFTARAN => 'Pendaftaran',
            self::MENUNGGU => 'Waiting List',
            self::LULUS => 'Lulus',
            self::TIDAK_LULUS => 'Tidak Lulus',
            self::MENGUNDURKAN_DIRI => 'Mengundurkan Diri',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDAFTARAN => 'info',
            self::MENUNGGU => 'primary',
            self::LULUS => 'success',
            self::TIDAK_LULUS => 'danger',
            self::MENGUNDURKAN_DIRI => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDAFTARAN => 'heroicon-o-sparkles',
            self::MENUNGGU => 'heroicon-o-pause-circle',
            self::LULUS => 'heroicon-o-check-circle',
            self::TIDAK_LULUS => 'heroicon-o-x-circle',
            self::MENGUNDURKAN_DIRI => 'heroicon-o-stop-circle',
        };
    }
}
