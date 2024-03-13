<?php

namespace App\Livewire\Pendaftar;

use App\Models\Pendaftaran;
use Livewire\Component;

class PendaftaranSayaComponent extends Component
{
    public Pendaftaran $pendaftaran;

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.pendaftar.pendaftaran-saya-component');
    }
}
