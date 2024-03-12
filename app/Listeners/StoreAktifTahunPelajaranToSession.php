<?php

namespace App\Listeners;

use App\Models\TahunPelajaran;

class StoreAktifTahunPelajaranToSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $id = $event->tahun->id ?? null;
        $nama = $event->tahun->nama ?? null;

        if (! $id) {
            $tahun = TahunPelajaran::whereAktif(true)->first();
            $id = $tahun->id;
            $nama = $tahun->nama;
        }

        session([
            'tahun_pelajaran_id' => $id,
            'tahun_pelajaran' => $nama,
        ]);
    }
}
