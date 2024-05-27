<?php

namespace App\Filament\Exports;

use App\Models\Periodik;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PeriodikExporter extends Exporter
{
    protected static ?string $model = Periodik::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('calonPesertaDidik.nama'),
            ExportColumn::make('calonPesertaDidik.asalSekolah.nama'),
            ExportColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode'),
            ExportColumn::make('tinggi'),
            ExportColumn::make('berat'),
            ExportColumn::make('lingkar_kepala'),
            ExportColumn::make('no_sepatu'),
            ExportColumn::make('ukuran_baju')
                ->state(fn (Periodik $record) => isset($record->ukuran_baju) ? $record->ukuran_baju->getLabel() : '-' ),
            ExportColumn::make('tindik'),
            ExportColumn::make('tato'),
            ExportColumn::make('cat_rambut'),
            ExportColumn::make('catatan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your periodik export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
