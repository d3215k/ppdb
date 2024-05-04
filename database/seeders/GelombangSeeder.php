<?php

namespace Database\Seeders;

use App\Models\Gelombang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GelombangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            'mulai' => today(),
            'sampai' => today()->addMonth(5),
            'aktif' => false,
        ]);
    }
}
