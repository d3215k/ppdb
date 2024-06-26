<?php

namespace Database\Seeders;

use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\TahunPelajaran;
use App\Support\GenerateNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalonPesertaDidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 100) as $item) {

            $cpd = CalonPesertaDidik::create([
                'nama' => 'Peserta Didik '. $item,
                'lp' => $item % 2 === 0 ? 'L' : 'P',
                'nisn' => '1234567890',
                'kewarganegaraan' => 'Indonesia',
                'nik' => '3202301234567899',
                'kk' => '3202301234567899',
                'tempat_lahir' => 'Sukabumi',
                'tanggal_lahir' => today()->subYear(rand(15,20)),
                'agama_id' => 1,
                'alamat' => 'alamat',
                'desa_kelurahan' => 'kelurahan',
                'kecamatan' => 'kecamatan',
                'kabupaten_kota' => 'kota',
                'provinsi' => 'provinsi',
                'tempat_tinggal_id' => rand(1,7),
                'moda_transportasi_id' => rand(1,9),
                'anak_ke' => rand(1,5),
                'nomor_hp' => '085659604324',
                'nomor_hp_ortu' => '085659604324',
                'email' => "cpd{$item}@example.com",
                'asal_sekolah_id' => rand(1,3),
            ]);

            $cpd->ortu()->create([
                'nama_ayah' => 'Ayah '. $item,
                'nama_ibu' => 'Ibu '. $item,
            ]);

            $cpd->rapor()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->periodik()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->btq()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->tes()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->persyaratanUmum()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $tahun = TahunPelajaran::whereAktif(true)->first();
            $gelombangId = rand(1,2);
            $gelombang = Gelombang::find($gelombangId);

            $cpd->pendaftaran()->create([
                'nomor' => GenerateNumber::pendaftaran($tahun, $gelombang),
                'gelombang_id' => $gelombangId,
                'jalur_id' => rand(1,5),
                'pilihan_kesatu' => rand(1,2),
                'pilihan_kedua' => rand(3,4),
                'created_at' => today()->subDays(rand(1,30))
            ]);

            // $cpd->user()->create([
            //     'name' => 'nama CPD',
            //     'email' => "cpd{$item}@example.com",
            //     'password' => bcrypt('password'),
            // ]);
        }
    }
}
