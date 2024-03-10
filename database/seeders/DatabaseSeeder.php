<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserType;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\TahunPelajaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RefDapodik::class,
            AsalSekolahSeeder::class,
        ]);

        $tahun = TahunPelajaran::create([
            'kode' => '2425',
            'nama' => '2024/2025',
            'aktif' => true,
        ]);

        Gelombang::create([
            'kode' => '1',
            'tahun_pelajaran_id' => $tahun->id,
            'nama' => 'Gelombang 1',
            'mulai' => today(),
            'sampai' => today()->addMonth(2),
            'aktif' => true,
        ]);

        Gelombang::create([
            'kode' => '2',
            'tahun_pelajaran_id' => $tahun->id,
            'nama' => 'Gelombang 2',
            'mulai' => today()->addMonth(3),
            'sampai' => today()->addMonth(5),
            'aktif' => false,
        ]);

        Jalur::create([
            'nama' => 'Afirmasi',
        ]);

        Jalur::create([
            'nama' => 'Perpindahan Tugas Orang tua/Wali/Anak Guru',
        ]);

        Jalur::create([
            'nama' => 'Prestasi',
        ]);

        Jalur::create([
            'nama' => 'Prioritas Terdekat',
        ]);

        KompetensiKeahlian::create([
            'kode' => 'AGRIN',
            'nama' => 'Agroindustri',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'MM',
            'nama' => 'Multimedia',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'APAT',
            'nama' => 'Agribisnis Perikanan Air Tawar',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'ATU',
            'nama' => 'Agribisnis Ternak Unggas',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'ATR',
            'nama' => 'Agribisnis Ternak Ruminansia',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'ATPH',
            'nama' => 'Agribisnis Tanaman Pangan dan Hortikultura',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'APHP',
            'nama' => 'Agribisnis Pengolahan Hasil Pertanian',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'PMHP',
            'nama' => 'Pengawasan Mutu Hasil Pertanian',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        User::create([
            'username' => 'advisor1',
            'name' => 'Advisor 1',
            'email' => 'advisor@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::PANITIA
        ]);

        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ADMIN
        ]);

        foreach (range(1,10) as $item) {

            $cpd = CalonPesertaDidik::create([
                'nama' => 'Nama Peserta Didik '. $item,
                'lp' => 'L',
                'agama_id' => 1,
                'berkebutuhan_khusus_id' => rand(1,16),
                'tempat_tinggal_id' => rand(1,7),
                'moda_transportasi_id' => rand(1,9),
            ]);

            $cpd->ayah()->create([
                'nama' => 'Ayah '. $item,
            ]);

            $cpd->ibu()->create([
                'nama' => 'Ibu '. $item,
            ]);

            $cpd->user()->create([
                'username' => '32023000000000'. $item,
                'email' => "cpd{$item}@example.com",
                'password' => bcrypt('password'),
            ]);
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
