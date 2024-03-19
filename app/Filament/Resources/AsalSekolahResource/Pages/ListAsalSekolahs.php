<?php

namespace App\Filament\Resources\AsalSekolahResource\Pages;

use App\Filament\Imports\AsalSekolahImporter;
use App\Filament\Resources\AsalSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsalSekolahs extends ListRecords
{
    protected static string $resource = AsalSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label('Impor')
                ->importer(AsalSekolahImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
