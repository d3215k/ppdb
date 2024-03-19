<?php

namespace Database\Seeders;

use App\Models\KompetensiKeahlian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KompetensiKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
