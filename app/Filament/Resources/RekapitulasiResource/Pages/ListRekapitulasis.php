<?php

namespace App\Filament\Resources\RekapitulasiResource\Pages;

use App\Filament\Resources\RekapitulasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapitulasis extends ListRecords
{
    protected static string $resource = RekapitulasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
