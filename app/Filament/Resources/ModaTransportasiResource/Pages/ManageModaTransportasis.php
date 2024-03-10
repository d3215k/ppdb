<?php

namespace App\Filament\Resources\ModaTransportasiResource\Pages;

use App\Filament\Resources\ModaTransportasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageModaTransportasis extends ManageRecords
{
    protected static string $resource = ModaTransportasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
