<?php

namespace App\Filament\Pages\Pendaftar;

use App\Traits\EnsureOnlyPendaftarCanAccess;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BerandaPage extends Page
{
    use EnsureOnlyPendaftarCanAccess;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pendaftar.beranda-page';

    protected static ?string $title = 'Beranda';

    public function getHeading(): string|Htmlable
    {
        return auth()->user()->name;
    }

}
