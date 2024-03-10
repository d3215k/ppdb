<?php

namespace App\Filament\Resources\JalurResource\Pages;

use App\Filament\Resources\JalurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJalur extends EditRecord
{
    protected static string $resource = JalurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
