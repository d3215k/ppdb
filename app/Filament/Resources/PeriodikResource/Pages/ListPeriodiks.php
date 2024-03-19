<?php

namespace App\Filament\Resources\PeriodikResource\Pages;

use App\Filament\Exports\PeriodikExporter;
use App\Filament\Resources\PeriodikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodiks extends ListRecords
{
    protected static string $resource = PeriodikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->label('Ekspor')
                ->exporter(PeriodikExporter::class)
            // Actions\CreateAction::make(),
        ];
    }
}
