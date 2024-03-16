<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCalonPesertaDidik extends EditRecord
{
    protected static string $resource = CalonPesertaDidikResource::class;

    protected static ?string $title = 'Calon Peserta Didik';

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
