<?php

namespace Database\Seeders;

use App\Models\Jalur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
