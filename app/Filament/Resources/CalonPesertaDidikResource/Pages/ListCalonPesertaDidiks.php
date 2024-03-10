<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalonPesertaDidiks extends ListRecords
{
    protected static string $resource = CalonPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
