<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia || auth()->user()->isPenguji;
    }

    public function mount()
    {
        if (auth()->user()->isPendaftar) {
            return to_route('pendaftar.dashboard');
        }
    }

}
