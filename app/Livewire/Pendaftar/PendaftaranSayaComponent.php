<?php

namespace App\Livewire\Pendaftar;

use App\Models\Pendaftaran;
use App\Models\PersyaratanKhusus;
use Livewire\Component;

class PendaftaranSayaComponent extends Component
{
    public Pendaftaran $pendaftaran;

    public ?array $data  = [];

    public bool $isComplete = false;

    public function mount()
    {
        $this->getAlurPendaftaran();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="shadow-sm bg-white p-4 w-full mx-auto">
            <div class="animate-pulse flex space-x-4">
                <div class="flex-1 space-y-6 py-1">
                <div class="h-6 bg-slate-200 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-6 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-6 bg-slate-200 rounded col-span-2"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-6 bg-slate-200 rounded col-span-1"></div>
                        <div class="h-6 bg-slate-200 rounded col-span-2"></div>
                    </div>
                    <div class="h-6 bg-slate-200 rounded"></div>
                </div>
                </div>
            </div>
        </div>
        HTML;
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
