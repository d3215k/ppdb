<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefDapodik extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_penghasilan')->upsert(
            [
                ['id' => 1, 'nama' => 'Kurang dari Rp500.000'],
                ['id' => 2, 'nama' => 'Rp500.000 - Rp999.999'],
                ['id' => 3, 'nama' => 'Rp1.000.000 - Rp1.999.999'],
                ['id' => 4, 'nama' => 'Rp2.000.000 - Rp4.999.999'],
                ['id' => 5, 'nama' => 'Rp5.000.000 - Rp20.000.000'],
                ['id' => 6, 'nama' => 'Lebih dari Rp10.000.000'],
                ['id' => 7, 'nama' => 'Tidak Berpenghasilan'],
            ],
            ['id'],
            ['nama']
        );

        DB::table('ref_tempat_tinggal')->upsert(
            [
                ['id' => 1, 'nama' => 'Bersama orang tua'],
                ['id' => 2, 'nama' => 'Wali'],
                ['id' => 3, 'nama' => 'Kost'],
                ['id' => 4, 'nama' => 'Asrama'],
                ['id' => 5, 'nama' => 'Panti asuhan'],
                ['id' => 6, 'nama' => 'Pesantren'],
                ['id' => 7, 'nama' => 'Lainnya'],
            ],
            ['id'],
            ['nama']
        );

        DB::table('ref_moda_transportasi')->upsert(
            [
                ['id' => 1, 'nama' => 'Jalan kaki'],
                ['id' => 2, 'nama' => 'Angkutan umum/bus/pete-pete'],
                ['id' => 3, 'nama' => 'Mobil/bus antar jemput'],
                ['id' => 4, 'nama' => 'Kereta api'],
                ['id' => 5, 'nama' => 'Ojek'],
                ['id' => 6, 'nama' => 'Andong/bedi/sado/dokar/delman/becak'],
                ['id' => 7, 'nama' => 'Perahu penyeberangan/rakit/getek'],
                ['id' => 8, 'nama' => 'Kuda'],
                ['id' => 9, 'nama' => 'Sepeda'],
            ],
            ['id'],
            ['nama']
        );

        DB::table('ref_berkebutuhan_khusus')->upsert(
            [
                ['id' => 1, 'nama' => 'netra (A)'],
                ['id' => 2, 'nama' => 'rungu (B)'],
                ['id' => 3, 'nama' => 'grahita ringan (C)'],
                ['id' => 4, 'nama' => 'grahita sedang (C1)'],
                ['id' => 5, 'nama' => 'daksa ringan (D)'],
                ['id' => 6, 'nama' => 'daksa sedang (D1)'],
                ['id' => 7, 'nama' => 'laras (E)'],
                ['id' => 8, 'nama' => 'wicara (F)'],
                ['id' => 9, 'nama' => 'hiperaktif (H)'],
                ['id' => 10, 'nama' => 'cerdas istimewa (I)'],
                ['id' => 11, 'nama' => 'bakat istimewa (J)'],
                ['id' => 12, 'nama' => 'kesulitan belajar (K)'],
                ['id' => 13, 'nama' => 'narkoba (N)'],
                ['id' => 14, 'nama' => 'indigo (O)'],
                ['id' => 15, 'nama' => 'down syndrome (P)'],
                ['id' => 16, 'nama' => 'autis (Q)'],
            ],
            ['id'],
            ['nama']
        );

        DB::table('ref_agama')->upsert(
            [
                ['id' => 1, 'nama' => 'Islam'],
                ['id' => 2, 'nama' => 'Kristen'],
                ['id' => 3, 'nama' => 'Katholik'],
                ['id' => 4, 'nama' => 'Hindu'],
                ['id' => 5, 'nama' => 'Budha'],
                ['id' => 6, 'nama' => 'Konghucu'],
                ['id' => 7, 'nama' => 'Kepercayaan kpd Tuhan YME'],
                ['id' => 8, 'nama' => 'Lainnya'],
            ],
            ['id'],
            ['nama']
        );
    }
}
