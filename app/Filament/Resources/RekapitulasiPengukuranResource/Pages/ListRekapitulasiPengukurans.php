<?php

namespace App\Filament\Resources\RekapitulasiPengukuranResource\Pages;

use App\Filament\Resources\RekapitulasiPengukuranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapitulasiPengukurans extends ListRecords
{
    protected static string $resource = RekapitulasiPengukuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
