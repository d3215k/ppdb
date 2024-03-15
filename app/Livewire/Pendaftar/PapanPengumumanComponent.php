<?php

namespace App\Livewire\Pendaftar;

use App\Models\Pengumuman;
use Livewire\Component;

class PapanPengumumanComponent extends Component
{
    public function render()
    {
        $pengumuman = Pengumuman::query()
            ->whereAktif(true)
            ->where('terbit', '<=', now())
            ->orderBy('pin', 'desc')
            ->orderBy('terbit', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.pendaftar.papan-pengumuman-component', [
            'pengumuman' => $pengumuman,
        ]);
    }
}
