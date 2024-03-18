<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use App\Enums\StatusPendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    use HasFactory;

    use \Sushi\Sushi;

    public function getRows()
    {
        $data = [];

        $jurusan = KompetensiKeahlian::all();
        $jalur = Jalur::all();

        $pendaftar = Pendaftaran::with('calonPesertaDidik')->get();

        foreach ($jurusan as $i => $s) {
            $data[$i] = [
                'nama' => $s->nama,
                'kuota' => $s->kuota()->sum('kuota'),
                'pendaftar_1' => $pendaftar->where('pilihan_kesatu', $s->id)->count(),
                'pendaftar_2' => $pendaftar->where('pilihan_kedua', $s->id)->count(),
                'diterima' => $pendaftar->where('kompetensi_keahlian', $s->id)->where('status', StatusPendaftaran::LULUS)->count(),
            ];

            foreach ($jalur as $j) {
                $data[$i][$j->id.'_nama'] = $j->nama;
                $data[$i][$j->id.'_pendaftar_1_l'] = Pendaftaran::where('pilihan_kesatu', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::LAKI_LAKI))->where('jalur_id', $j->id)->count();
                $data[$i][$j->id.'_pendaftar_1_p'] = Pendaftaran::where('pilihan_kesatu', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::PEREMPUAN))->where('jalur_id', $j->id)->count();
                $data[$i][$j->id.'_pendaftar_2_l'] = Pendaftaran::where('pilihan_kedua', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::LAKI_LAKI))->where('jalur_id', $j->id)->count();
                $data[$i][$j->id.'_pendaftar_2_p'] = Pendaftaran::where('pilihan_kedua', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::PEREMPUAN))->where('jalur_id', $j->id)->count();
                $data[$i][$j->id.'_diterima_l'] = Pendaftaran::where('kompetensi_keahlian', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::LAKI_LAKI))->where('status', StatusPendaftaran::LULUS)->where('jalur_id', $j->id)->count();
                $data[$i][$j->id.'_diterima_p'] = Pendaftaran::where('kompetensi_keahlian', $s->id)->whereHas('calonPesertaDidik', fn ($query) => $query->where('lp', JenisKelamin::PEREMPUAN))->where('status', StatusPendaftaran::LULUS)->where('jalur_id', $j->id)->count();
            }
        }

        return $data;
    }
}
