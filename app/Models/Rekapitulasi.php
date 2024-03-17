<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    use HasFactory;

    use \Sushi\Sushi;

    public function getRows()
    {
        $data = [];

        $pilihanKesatu = KompetensiKeahlian::where('dipilih_kesatu', true)->get();
        $pilihanKedua = KompetensiKeahlian::where('dipilih_kedua', true)->get();

        $jalur = Jalur::all();

        foreach ($pilihanKesatu as $i => $s) {
            foreach ($jalur as $z => $j) {
                $data[$i] = [
                    'nama' => $s->nama,
                ];

                $data[$i]['data'][$z] = [
                    'jalur' => $j->nama,
                    'kuota' => 50,
                    'pendaftar' => [
                        'l' => 20,
                        'p' => 10,
                    ],
                    'diterima' => [
                        'l' => 20,
                        'p' => 10,
                    ],
                ];
            }
        }

        // dd($data);

        return [
            [
                'foo' => 'bar'
            ],
        ];
    }
}
