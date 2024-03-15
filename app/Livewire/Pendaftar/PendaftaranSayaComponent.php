<?php

namespace App\Livewire\Pendaftar;

use App\Models\Pendaftaran;
use App\Models\PersyaratanKhusus;
use App\Traits\WithPlaceholder;
use Livewire\Component;

class PendaftaranSayaComponent extends Component
{
    use WithPlaceholder;

    public Pendaftaran $pendaftaran;

    public ?array $data  = [];

    public bool $isComplete = false;

    public function mount()
    {
        $this->getAlurPendaftaran();
    }

    public function getAlurPendaftaran(): void
    {
        $isBiodataComplete = $this->pendaftaran->calonPesertaDidik->isComplete();
        $isRaporComplete = $this->pendaftaran->calonPesertaDidik->rapor->isComplete();
        $isBerkasComplete = $this->pendaftaran->calonPesertaDidik->persyaratanUmum->isComplete() & $this->pendaftaran->buktiPersyaratanKhusus->count() >= PersyaratanKhusus::whereAktif(true)->where('jalur_id', $this->pendaftaran->jalur_id)->count();

        $this->isComplete = $isBiodataComplete && $isRaporComplete && $isBerkasComplete;

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
                'isComplete' =>$isBiodataComplete,
                'href' => route('pendaftar.biodata'),
            ],
            [
                'heading' => 'Rapor',
                'description' => 'Semester 1 sampai 5',
                'isComplete' => $isRaporComplete,
                'href' => route('pendaftar.rapor'),
            ],
            [
                'heading' => 'Pemberkasan',
                'description' => 'Unggah Berkas Persyaratan',
                'isComplete' => $isBerkasComplete,
                'href' => route('pendaftar.berkas'),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pendaftar.pendaftaran-saya-component');
    }
}
