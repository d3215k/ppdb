<?php

namespace App\Filament\Resources\PeriodikResource\Pages;

use App\Filament\Resources\PeriodikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriodik extends EditRecord
{
    protected static string $resource = PeriodikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
