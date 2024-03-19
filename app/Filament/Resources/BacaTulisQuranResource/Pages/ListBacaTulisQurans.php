<?php

namespace App\Filament\Resources\BacaTulisQuranResource\Pages;

use App\Filament\Exports\BacaTulisQuranExporter;
use App\Filament\Resources\BacaTulisQuranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBacaTulisQurans extends ListRecords
{
    protected static string $resource = BacaTulisQuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(BacaTulisQuranExporter::class)
            // Actions\CreateAction::make(),
        ];
    }
}
