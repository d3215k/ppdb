<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Exports\PendaftaranExporter;
use App\Filament\Resources\PendaftaranResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListPendaftarans extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export Data')
                ->exporter(PendaftaranExporter::class)
        ];
    }

}
