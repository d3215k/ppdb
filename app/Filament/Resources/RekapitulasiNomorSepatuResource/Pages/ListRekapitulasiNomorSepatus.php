<?php

namespace App\Filament\Resources\RekapitulasiNomorSepatuResource\Pages;

use App\Filament\Resources\RekapitulasiNomorSepatuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapitulasiNomorSepatus extends ListRecords
{
    protected static string $resource = RekapitulasiNomorSepatuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
