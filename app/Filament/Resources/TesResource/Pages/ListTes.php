<?php

namespace App\Filament\Resources\TesResource\Pages;

use App\Filament\Exports\TesExporter;
use App\Filament\Resources\TesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTes extends ListRecords
{
    protected static string $resource = TesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(TesExporter::class)
            // Actions\CreateAction::make(),
        ];
    }
}
