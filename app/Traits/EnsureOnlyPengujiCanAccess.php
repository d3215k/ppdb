<?php
namespace App\Traits;

trait EnsureOnlyPengujiCanAccess {

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia || auth()->user()->isPenguji;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia || auth()->user()->isPenguji;
    }

}
