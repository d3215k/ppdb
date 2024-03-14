<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Enums\UkuranBaju;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\ModaTransportasi;
use App\Models\Pendaftaran;
use App\Models\Periodik;
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

class BiodataComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $cpd = [];
    public ?array $periodik = [];

    #[Computed()]
    public function calonPesertaDidik()
    {
        return CalonPesertaDidik::find(auth()->user()->calon_peserta_didik_id);
    }

    public function mount(): void
    {
        $this->calonPesertaDidikForm->fill(
            $this->calonPesertaDidik()?->toArray()
        );

        $this->periodikForm->fill(
            Periodik::find(auth()->user()->calon_peserta_didik_id)?->toArray()
        );
    }

    public function getForms(): array
    {
        return [
            'periodikForm',
            'calonPesertaDidikForm',
        ];
    }

    public function periodikForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tinggi')
                    ->nullable()
                    ->suffix('cm')
                    ->numeric(),
                Forms\Components\TextInput::make('berat')
                    ->nullable()
                    ->suffix('Kg')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_kepala')
                    ->nullable()
                    ->numeric(),
                Forms\Components\TextInput::make('no_sepatu')
                    ->nullable()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('ukuran_baju')
                    ->inline()
                    ->nullable()
                    ->options(UkuranBaju::class),
            ])
            ->columns(2)
            ->statePath('periodik');
        }

    public function calonPesertaDidikForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('foto')
                    ->label('Photo')
                    ->image()
                    ->maxSize(512)
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ToggleButtons::make('lp')
                    ->inline()
                    ->label('L/P')
                    ->options(JenisKelamin::class)
                    ->required(),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->maxLength(10),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->maxLength(16),
                Forms\Components\TextInput::make('kk')
                    ->label('Nomor KK')
                    ->maxLength(16),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('no_reg_akta')
                    ->maxLength(255),
                Forms\Components\Select::make('agama_id')
                    ->options(Agama::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('berkebutuhan_khusus_id')
                    ->options(BerkebutuhanKhusus::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('alamat')
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->maxLength(255),
                Forms\Components\TextInput::make('dusun')
                    ->maxLength(255),
                Forms\Components\TextInput::make('desa_kelurahan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('desa_kelurahan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lintang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bujur')
                    ->maxLength(255),
                Forms\Components\Select::make('tempat_tinggal_id')
                    ->options(TempatTinggal::pluck('nama', 'id')),
                Forms\Components\Select::make('moda_transportasi_id')
                    ->options(ModaTransportasi::pluck('nama', 'id')),
                Forms\Components\TextInput::make('anak_ke')
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_hp')
                    ->label('Nomor HP (Aktif Whatsapp)')
                    ->maxLength(16),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('asal_sekolah_id')
                    ->options(AsalSekolah::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
            ])
            ->columns(2)
            ->statePath('cpd');
    }

    public function handleSubmit(): void
    {
        try {
            DB::beginTransaction();

            $cpd = $this->calonPesertaDidikForm->getState();
            $periodik = $this->periodikForm->getState();

            $this->calonPesertaDidik()->update($cpd);

            Periodik::updateOrCreate(
                [
                    'calon_peserta_didik_id' => auth()->user()->calon_peserta_didik_id
                ],
                $periodik
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
        return view('livewire.pendaftar.biodata-component');
    }
}
