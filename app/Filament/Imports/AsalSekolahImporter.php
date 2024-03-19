<?php

namespace App\Filament\Imports;

use App\Models\AsalSekolah;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AsalSekolahImporter extends Importer
{
    protected static ?string $model = AsalSekolah::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->rules(['required', 'max:255']),
            ImportColumn::make('npsn')
                ->rules(['length:8']),
            ImportColumn::make('alamat')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?AsalSekolah
    {
        return AsalSekolah::firstOrNew([
            'npsn' => $this->data['npsn'],
        ]);

        // return new AsalSekolah();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor Asal sekolah selesai dan berhasil impor ' . number_format($import->successful_rows) . ' baris data.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal untuk impor.';
        }

        return $body;
    }
}
