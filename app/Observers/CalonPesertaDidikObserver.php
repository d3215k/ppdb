<?php

namespace App\Observers;

use App\Models\CalonPesertaDidik;

class CalonPesertaDidikObserver
{
    /**
     * Handle the CalonPesertaDidik "created" event.
     */
    public function created(CalonPesertaDidik $calonPesertaDidik): void
    {
        $calonPesertaDidik->ortu()->updateOrCreate([
                'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

        $calonPesertaDidik->rapor()->updateOrCreate([
            'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

        $calonPesertaDidik->periodik()->updateOrCreate([
            'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

        $calonPesertaDidik->btq()->updateOrCreate([
            'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

        $calonPesertaDidik->tes()->updateOrCreate([
            'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

        $calonPesertaDidik->persyaratanUmum()->updateOrCreate([
            'calon_peserta_didik_id' => $calonPesertaDidik->id
        ]);

    }

    /**
     * Handle the CalonPesertaDidik "updated" event.
     */
    public function updated(CalonPesertaDidik $calonPesertaDidik): void
    {
        //
    }

    /**
     * Handle the CalonPesertaDidik "deleted" event.
     */
    public function deleted(CalonPesertaDidik $calonPesertaDidik): void
    {
        //
    }

    /**
     * Handle the CalonPesertaDidik "restored" event.
     */
    public function restored(CalonPesertaDidik $calonPesertaDidik): void
    {
        //
    }

    /**
     * Handle the CalonPesertaDidik "force deleted" event.
     */
    public function forceDeleted(CalonPesertaDidik $calonPesertaDidik): void
    {
        //
    }
}
