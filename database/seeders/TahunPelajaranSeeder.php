<?php

namespace Database\Seeders;

use App\Models\TahunPelajaran;
use App\Settings\SettingSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
