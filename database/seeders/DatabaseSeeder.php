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
use App\Settings\SettingSekolah;
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

        session([
            'tahun_pelajaran_id' => $tahun->id,
        ]);

        $setting = new SettingSekolah();
        $setting->tahun_pelajaran_aktif = $tahun->id;
        $setting->save();

        KompetensiKeahlian::create([
            'kode' => 'DKV',
            'nama' => 'Desain Komunikasi Visual',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => false,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'APR',
            'nama' => 'Agribisnis Perikanan',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'ATR',
            'nama' => 'Agribisnis Ternak',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'ATN',
            'nama' => 'Agribisnis Tanaman',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => true,
        ]);

        KompetensiKeahlian::create([
            'kode' => 'APHP',
            'nama' => 'Agriteknologi Pengolahan Hasil Pertanian',
            'dipilih_kesatu' => true,
            'dipilih_kedua' => false,
        ]);

        Gelombang::create([
            'kode' => '1',
            'nama' => 'Gelombang 1',
            'mulai' => today(),
            'sampai' => today()->addMonth(2),
            'aktif' => true,
        ]);

        Gelombang::create([
            'kode' => '2',
            'nama' => 'Gelombang 2',
            'mulai' => today()->addMonth(3),
            'sampai' => today()->addMonth(5),
            'aktif' => false,
        ]);

        $ketm = Jalur::create([
            'nama' => 'Afirmasi KETM',
        ]);

        $pdbk = Jalur::create([
            'nama' => 'Afirmasi PDBK (DISABILITAS/CIBI)',
        ]);

        $tertentu = Jalur::create([
            'nama' => 'Afirmasi Kondisi Tertentu',
        ]);

        $terdekat = Jalur::create([
            'nama' => 'Prioritas Terdekat',
        ]);

        $ortu = Jalur::create([
            'nama' => 'Perpindahan Tugas Orang tua/Wali/Anak Guru',
        ]);

        $industri = Jalur::create([
            'nama' => 'Persiapan Kelas Industri (Raport Unggulan)',
        ]);

        $kejuaraan = Jalur::create([
            'nama' => 'Prestasi Kejuaraan',
        ]);

        $umum = Jalur::create([
            'nama' => 'Raport Umum',
        ]);

        // KompetensiKeahlian::create([
        //     'kode' => 'AGRIN',
        //     'nama' => 'Agroindustri',
        //     'dipilih_kesatu' => true,
        //     'dipilih_kedua' => true,
        // ]);

        User::create([
            'name' => 'Panitia 1',
            'email' => 'panitia@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::PANITIA
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ADMIN
        ]);

        foreach (range(1,10) as $item) {

            $cpd = CalonPesertaDidik::create([
                'nama' => 'Peserta Didik '. $item,
                'lp' => 'L',
                'agama_id' => 1,
                'tempat_tinggal_id' => rand(1,7),
                'moda_transportasi_id' => rand(1,9),
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

            $cpd->persyaratanUmum()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->user()->create([
                'name' => 'nama CPD',
                'email' => "cpd{$item}@example.com",
                'password' => bcrypt('password'),
            ]);
        }

    }
}
