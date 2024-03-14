<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\BuktiPersyaratanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\ModaTransportasi;
use App\Models\Pendaftaran;
use App\Models\PersyaratanKhusus;
use App\Models\PersyaratanUmum;
use App\Models\Rapor;
use App\Models\TahunPelajaran;
use App\Models\TempatTinggal;
use App\Support\GenerateNumber;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BerkasComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $umum = [];
    public ?array $khusus = [];

    #[Computed()]
    public function pendaftaran()
    {
        return Pendaftaran::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first();
    }

    #[Computed()]
    public function persyaratanKhusus()
    {
        return PersyaratanKhusus::where('jalur_id', $this->pendaftaran()->jalur_id)->get();
    }

    public function mount(): void
    {
        $this->persyaratanUmumForm->fill(
            PersyaratanUmum::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first()?->toArray()
        );

        $this->persyaratanKhususForm->fill(
            BuktiPersyaratanKhusus::where('pendaftaran_id', $this->pendaftaran()->id)->pluck('file', 'id')->toArray()
        );
    }

    protected function getForms(): array
    {
        return [
            'persyaratanUmumForm',
            'persyaratanKhususForm',
        ];
    }

    public function persyaratanUmumForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('dokumen_kelulusan')
                    ->required()
                    ->downloadable(),
                Forms\Components\FileUpload::make('dokumen_kelahiran')
                    ->required()
                    ->downloadable(),
                Forms\Components\FileUpload::make('kartu_keluarga')
                    ->required()
                    ->downloadable(),
                Forms\Components\FileUpload::make('ktp_ortu')
                    ->required()
                    ->downloadable(),

            ])
            ->columns(2)
            ->statePath('umum');
    }

    public function persyaratanKhususForm(Form $form): Form
    {
        $persyaratanKhusus = PersyaratanKhusus::where('jalur_id', $this->pendaftaran()->jalur_id)
            ->get();

        $fields = [];

        foreach ($persyaratanKhusus as $syarat) {
            $fields[] = Forms\Components\FileUpload::make($syarat->id)
                ->label($syarat->nama)
                ->downloadable()
                ->required();
        }

        return $form
            ->schema($fields)
            ->columns(2)
            ->statePath('khusus');
    }

    public function handleSubmit(): void
    {
        try {
            DB::beginTransaction();

            $khusus = $this->persyaratanKhususForm->getState();

            foreach ($this->persyaratanKhusus() as $syarat) {
                BuktiPersyaratanKhusus::updateOrCreate(
                    [
                        'pendaftaran_id' => $this->pendaftaran()->id,
                        'persyaratan_khusus_id' => $syarat->id,
                    ],
                    [
                        'file' => $khusus[$syarat->id],
                    ]
                );
            }

            $umum = $this->persyaratanUmumForm->getState();

            PersyaratanUmum::updateOrCreate(
                [
                    'pendaftaran_id' => $this->pendaftaran()->id,
                ],
                $umum,
            );

            Notification::make()->title('berhasil')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title($th->getMessage())->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.berkas-component');
    }
}
