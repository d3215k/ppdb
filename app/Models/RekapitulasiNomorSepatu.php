<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use App\Enums\StatusPendaftaran;
use App\Enums\UkuranSepatu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiNomorSepatu extends Model
{
    use HasFactory;

    use \Sushi\Sushi;

    public function getRows()
    {
        $data = [];

        foreach (UkuranSepatu::cases() as $ukuran) {
            $data[] = [
                'nama' => $ukuran->getLabel(),
                'l' => Periodik::query()
                    ->where('no_sepatu', $ukuran)
                    ->whereHas(
                        'calonPesertaDidik',
                        fn ($query) => $query
                            ->where('lp', JenisKelamin::LAKI_LAKI)
                            ->whereHas(
                                'pendaftaran',
                                fn ($query) => $query->where('status', StatusPendaftaran::LULUS)
                            )
                    )
                    ->count(),
                'p' => Periodik::query()
                    ->where('no_sepatu', $ukuran->value)
                    ->whereHas(
                        'calonPesertaDidik',
                        fn ($query) => $query
                            ->where('lp', JenisKelamin::PEREMPUAN)
                            ->whereHas(
                                'pendaftaran',
                                fn ($query) => $query->where('status', StatusPendaftaran::LULUS)
                            )
                    )
                    ->count(),
            ];
        }

        return $data;
    }
}
