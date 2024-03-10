<?php

namespace App\Filament\Resources\PenghasilanResource\Pages;

use App\Filament\Resources\PenghasilanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePenghasilans extends ManageRecords
{
    protected static string $resource = PenghasilanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
