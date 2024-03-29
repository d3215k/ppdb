<?php

namespace App\Filament\Resources\BacaTulisQuranResource\Pages;

use App\Filament\Resources\BacaTulisQuranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditBacaTulisQuran extends EditRecord
{
    protected static string $resource = BacaTulisQuranResource::class;

    protected function afterSave(): void
    {
        if (auth()->user()->isPenguji) {
            $this->getRecord()->update([
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function getHeading(): string
    {
        return $this->getRecord()->calonPesertaDidik->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->calonPesertaDidik->asalSekolah->nama ?? '-';
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
