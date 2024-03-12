<?php
namespace App\Traits;

trait EnsureOnlyPanitiaCanAccess {

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia;
    }

}
