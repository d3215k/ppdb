<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditPendaftaran extends EditRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return $this->getRecord()->calonPesertaDidik->nama .' ('.$this->getRecord()->nomor.')';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->calonPesertaDidik->asalSekolah->nama ?? '-';
    }
}
