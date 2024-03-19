<?php

namespace App\Filament\Exports;

use App\Models\Tes;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TesExporter extends Exporter
{
    protected static ?string $model = Tes::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('calonPesertaDidik.nama'),
            ExportColumn::make('calonPesertaDidik.asalSekolah.nama'),
            ExportColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                ->label('Pilihan Kesatu'),
            ExportColumn::make('minat_bakat'),
            ExportColumn::make('khusus'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tes export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
