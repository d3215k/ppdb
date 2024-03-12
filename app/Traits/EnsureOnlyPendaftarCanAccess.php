<?php
namespace App\Traits;

trait EnsureOnlyPendaftarCanAccess {

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isPendaftar;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isPendaftar;
    }

}
