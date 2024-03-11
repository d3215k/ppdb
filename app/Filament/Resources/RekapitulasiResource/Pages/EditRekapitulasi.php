<?php

namespace App\Filament\Resources\RekapitulasiResource\Pages;

use App\Filament\Resources\RekapitulasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekapitulasi extends EditRecord
{
    protected static string $resource = RekapitulasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
