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
            TahunPelajaranSeeder::class,
            KompetensiKeahlianSeeder::class,
            JalurSeeder::class,
            GelombangSeeder::class,
            UserSeeder::class,
            CalonPesertaDidikSeeder::class,
        ]);

    }
}
