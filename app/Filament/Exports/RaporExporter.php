<?php

namespace App\Filament\Exports;

use App\Models\Rapor;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RaporExporter extends Exporter
{
    protected static ?string $model = Rapor::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('calonPesertaDidik.nama'),
            ExportColumn::make('calonPesertaDidik.asalSekolah.nama'),
            ExportColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                ->label('Pilihan Kesatu'),
            ExportColumn::make('sum')
                ->label('Total'),
            ExportColumn::make('avg')
                ->label('Rata-rata'),
            ExportColumn::make('pai'),
            ExportColumn::make('pai_1'),
            ExportColumn::make('pai_2'),
            ExportColumn::make('pai_3'),
            ExportColumn::make('pai_4'),
            ExportColumn::make('pai_5'),
            ExportColumn::make('bindo'),
            ExportColumn::make('bindo_1'),
            ExportColumn::make('bindo_2'),
            ExportColumn::make('bindo_3'),
            ExportColumn::make('bindo_4'),
            ExportColumn::make('bindo_5'),
            ExportColumn::make('mtk'),
            ExportColumn::make('mtk_1'),
            ExportColumn::make('mtk_2'),
            ExportColumn::make('mtk_3'),
            ExportColumn::make('mtk_4'),
            ExportColumn::make('mtk_5'),
            ExportColumn::make('ipa'),
            ExportColumn::make('ipa_1'),
            ExportColumn::make('ipa_2'),
            ExportColumn::make('ipa_3'),
            ExportColumn::make('ipa_4'),
            ExportColumn::make('ipa_5'),
            ExportColumn::make('ips'),
            ExportColumn::make('ips_1'),
            ExportColumn::make('ips_2'),
            ExportColumn::make('ips_3'),
            ExportColumn::make('ips_4'),
            ExportColumn::make('ips_5'),
            ExportColumn::make('bing'),
            ExportColumn::make('bing_1'),
            ExportColumn::make('bing_2'),
            ExportColumn::make('bing_3'),
            ExportColumn::make('bing_4'),
            ExportColumn::make('bing_5'),
            ExportColumn::make('sakit'),
            ExportColumn::make('izin'),
            ExportColumn::make('alpa'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your rapor export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
