<?php

namespace Database\Seeders;

use App\Models\AsalSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsalSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AsalSekolah::insert([
            ['nama' => 'SMPN 1 Cibadak', 'alamat' => 'Cibadak'],
            ['nama' => 'SMPN 2 Cibadak', 'alamat' => 'Cibadak'],
            ['nama' => 'SMPN 1 Cisaat', 'alamat' => 'Cisaat'],
            ['nama' => 'SMPN 2 Cisaat', 'alamat' => 'Cisaat'],
        ]);
    }
}
