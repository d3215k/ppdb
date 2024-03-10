<?php

namespace App\Filament\Resources\BerkebutuhanKhususResource\Pages;

use App\Filament\Resources\BerkebutuhanKhususResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBerkebutuhanKhususes extends ManageRecords
{
    protected static string $resource = BerkebutuhanKhususResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
