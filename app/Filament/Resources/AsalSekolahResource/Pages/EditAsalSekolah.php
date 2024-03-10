<?php

namespace App\Filament\Resources\AsalSekolahResource\Pages;

use App\Filament\Resources\AsalSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsalSekolah extends EditRecord
{
    protected static string $resource = AsalSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
