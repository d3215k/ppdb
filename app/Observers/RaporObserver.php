<?php

namespace App\Observers;

use App\Models\Rapor;

class RaporObserver
{
    /**
     * Handle the Rapor "created" event.
     */
    public function created(Rapor $rapor): void
    {
        //
    }

    /**
     * Handle the Rapor "updated" event.
     */
    public function updated(Rapor $rapor): void
    {
        //
    }

    /**
     * Handle the Rapor "deleted" event.
     */
    public function deleted(Rapor $rapor): void
    {
        //
    }

    /**
     * Handle the Rapor "restored" event.
     */
    public function restored(Rapor $rapor): void
    {
        //
    }

    /**
     * Handle the Rapor "force deleted" event.
     */
    public function forceDeleted(Rapor $rapor): void
    {
        //
    }
}
