<?php

namespace App\Filament\Exports;

use App\Models\BacaTulisQuran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BacaTulisQuranExporter extends Exporter
{
    protected static ?string $model = BacaTulisQuran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('calonPesertaDidik.nama'),
            ExportColumn::make('calonPesertaDidik.asalSekolah.nama'),
            ExportColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                ->label('Pilihan Kesatu'),
            ExportColumn::make('penguji.name'),
            ExportColumn::make('kelancaran'),
            ExportColumn::make('kefasihan'),
            ExportColumn::make('tajwid'),
            ExportColumn::make('keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your baca tulis quran export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
