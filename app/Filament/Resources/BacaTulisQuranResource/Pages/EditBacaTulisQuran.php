<?php

namespace App\Filament\Resources\BacaTulisQuranResource\Pages;

use App\Filament\Resources\BacaTulisQuranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBacaTulisQuran extends EditRecord
{
    protected static string $resource = BacaTulisQuranResource::class;

    protected function afterSave(): void
    {
        if (true) { // TODO : is not admin
            $this->getRecord()->btq()->update([
                'user_id' => auth()->id(),
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
