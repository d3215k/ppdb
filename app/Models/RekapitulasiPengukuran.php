<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use App\Enums\StatusPendaftaran;
use App\Enums\UkuranBaju;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiPengukuran extends Model
{
    use HasFactory;

    use \Sushi\Sushi;

    public function getRows()
    {
        $data = [];

        foreach (UkuranBaju::cases() as $ukuran) {
            $data[] = [
                'nama' => $ukuran->getLabel(),
                'l' => Periodik::query()
                    ->where('ukuran_baju', $ukuran)
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
                    ->where('ukuran_baju', $ukuran->value)
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
