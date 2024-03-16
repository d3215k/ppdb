<?php

namespace App\Filament\Resources\PeriodikResource\Pages;

use App\Filament\Resources\PeriodikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditPeriodik extends EditRecord
{
    protected static string $resource = PeriodikResource::class;

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
            Actions\DeleteAction::make(),
        ];
    }
}
