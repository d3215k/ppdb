<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCalonPesertaDidik extends EditRecord
{
    protected static string $resource = CalonPesertaDidikResource::class;

    protected static ?string $title = 'Calon Peserta Didik';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
