<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DashboardPendaftaranChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pendaftaran 30 Hari Terakhir';

    protected static ?string $maxHeight = '300px';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return ! auth()->user()->isPenguji;
    }

    protected function getData(): array
    {
        $data = Trend::model(Pendaftaran::class)
                ->between(
                    start: now()->copy()->subDays(30),
                    end: now(),
                )
                ->perDay()
                ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
