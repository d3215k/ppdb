<?php

namespace App\Filament\Widgets;

use App\Enums\StatusPendaftaran;
use App\Models\AsalSekolah;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Pendaftar', CalonPesertaDidik::count()),
            Stat::make('Jumlah Yang Sudah Diterima', Pendaftaran::where('status', StatusPendaftaran::LULUS)->count()),
            Stat::make('Pilihan Kompetensi Keahlian', KompetensiKeahlian::count()),
            Stat::make('Jalur Pendaftaran', Jalur::count()),
            Stat::make('Gelombang Pendaftaran', Jalur::count()),
            Stat::make('Asal Sekolah', AsalSekolah::whereHas('calonPesertaDidik')->count()),
        ];
    }
}