<?php

namespace App\Observers;

use App\Models\Jalur;
use App\Models\KompetensiKeahlian;

class JalurObserver
{
    /**
     * Handle the Jalur "created" event.
     */
    public function created(Jalur $jalur): void
    {
        $ids = KompetensiKeahlian::pluck('id');
        $jalur->kuota()->attach($ids);
    }

    /**
     * Handle the Jalur "updated" event.
     */
    public function updated(Jalur $jalur): void
    {
        //
    }

    /**
     * Handle the Jalur "deleted" event.
     */
    public function deleted(Jalur $jalur): void
    {
        //
    }

    /**
     * Handle the Jalur "restored" event.
     */
    public function restored(Jalur $jalur): void
    {
        //
    }

    /**
     * Handle the Jalur "force deleted" event.
     */
    public function forceDeleted(Jalur $jalur): void
    {
        //
    }
}
