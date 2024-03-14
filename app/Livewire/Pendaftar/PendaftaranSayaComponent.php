<?php

namespace App\Livewire\Pendaftar;

use App\Models\Pendaftaran;
use Livewire\Component;

class PendaftaranSayaComponent extends Component
{
    public Pendaftaran $pendaftaran;

    public ?array $data  = [];

    public function mount()
    {
        $this->getAlurPendaftaran();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            Loading...
        </div>
        HTML;
    }

    public function getAlurPendaftaran(): void
    {
        $this->data = [
            [
                'heading' => 'Pendaftaran',
                'description' => 'Pilih Jalur dan Gelombang',
                'isComplete' => true,
                'href' => route('pendaftar.dashboard'),
            ],
            [
                'heading' => 'Biodata',
                'description' => 'Isi data profil lengkap',
                'isComplete' => false,
                'href' => route('pendaftar.biodata'),
            ],
            [
                'heading' => 'Rapor',
                'description' => 'Semester 1 sampai 5',
                'isComplete' => false,
                'href' => route('pendaftar.rapor'),
            ],
            [
                'heading' => 'Pemberkasan',
                'description' => 'Unggah Berkas Persyaratan',
                'isComplete' => false,
                'href' => route('pendaftar.berkas'),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pendaftar.pendaftaran-saya-component');
    }
}
