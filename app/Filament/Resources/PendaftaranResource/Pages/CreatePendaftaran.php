<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Models\Gelombang;
use App\Models\TahunPelajaran;
use App\Support\GenerateNumber;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftaran extends CreateRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tahun = TahunPelajaran::whereAktif(true)->first();
        $gelombang = Gelombang::find($data['gelombang_id']);
        $data['tahun_pelajaran_id'] = $tahun->id;
        $data['nomor'] = GenerateNumber::pendaftaran($tahun, $gelombang);

        return $data;
    }
}
