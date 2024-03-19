<?php

namespace App\Filament\Resources\RaporResource\Pages;

use App\Filament\Exports\RaporExporter;
use App\Filament\Resources\RaporResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRapors extends ListRecords
{
    protected static string $resource = RaporResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(RaporExporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
