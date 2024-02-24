<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserType;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
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
            'nama' => '2024',
            'aktif' => true,
        ]);

        Gelombang::create([
            'tahun_pelajaran_id' => $tahun->id,
            'nama' => 'Gelombang 1',
            'mulai' => today(),
            'sampai' => today()->addMonth(2),
            'aktif' => true,
        ]);

        Gelombang::create([
            'tahun_pelajaran_id' => $tahun->id,
            'nama' => 'Gelombang 2',
            'mulai' => today()->addMonth(3),
            'sampai' => today()->addMonth(5),
            'aktif' => true,
        ]);

        User::create([
            'username' => 'advisor1',
            'email' => 'advisor@example.com',
            'password' => bcrypt('password'),
            'type' => UserType::ADVISOR
        ]);

        User::create([
            'username' => 'admin',
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
