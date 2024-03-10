<?php

namespace App\Filament\Resources\TempatTinggalResource\Pages;

use App\Filament\Resources\TempatTinggalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTempatTinggals extends ManageRecords
{
    protected static string $resource = TempatTinggalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
