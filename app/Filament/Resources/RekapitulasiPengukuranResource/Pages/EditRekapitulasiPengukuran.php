<?php

namespace App\Filament\Resources\RekapitulasiPengukuranResource\Pages;

use App\Filament\Resources\RekapitulasiPengukuranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekapitulasiPengukuran extends EditRecord
{
    protected static string $resource = RekapitulasiPengukuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
