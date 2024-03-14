<?php

namespace App\Livewire\Pendaftar;

use App\Models\BuktiPersyaratanKhusus;
use App\Models\Pendaftaran;
use App\Models\PersyaratanKhusus;
use App\Models\PersyaratanUmum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
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
        return Pendaftaran::query()->aktif()->first();
    }

    #[Computed()]
    public function persyaratanKhusus()
    {
        return PersyaratanKhusus::where('jalur_id', $this->pendaftaran()->jalur_id)->get();
    }

    public function mount()
    {
        if (!auth()->user()->calon_peserta_didik_id) {
            return to_route('pendaftar.dashboard');
        }

        $this->persyaratanUmumForm->fill(
            PersyaratanUmum::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first()?->toArray()
        );

        if ($this->pendaftaran()) {
            $this->persyaratanKhususForm->fill(
                BuktiPersyaratanKhusus::where('pendaftaran_id', $this->pendaftaran()->id)->pluck('file', 'id')->toArray()
            );
        }
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
        $fields = [];

        if ($this->pendaftaran()) {
            $persyaratanKhusus = PersyaratanKhusus::where('jalur_id', $this->pendaftaran()->jalur_id)
                ->get();

            foreach ($persyaratanKhusus as $syarat) {
                $fields[] = Forms\Components\FileUpload::make($syarat->id)
                    ->label($syarat->nama)
                    ->downloadable()
                    ->required();
            }
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

            if ($this->pendaftaran()) {
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
            }

            $umum = $this->persyaratanUmumForm->getState();

            PersyaratanUmum::updateOrCreate(
                [
                    'calon_peserta_didik_id' => auth()->user()->calon_peserta_didik_id,
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
