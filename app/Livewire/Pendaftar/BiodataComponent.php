<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\ModaTransportasi;
use App\Models\TempatTinggal;
use App\Traits\WithPlaceholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BiodataComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use WithPlaceholder;

    public ?array $cpd = [];

    #[Computed()]
    public function calonPesertaDidik()
    {
        return CalonPesertaDidik::find(auth()->user()->calon_peserta_didik_id);
    }

    public function mount()
    {
        $this->calonPesertaDidikForm->fill(
            $this->calonPesertaDidik->toArray()
        );
    }

    public function getForms(): array
    {
        return [
            'calonPesertaDidikForm',
        ];
    }

    public function calonPesertaDidikForm(Form $form): Form
    {
        return $form
            // ->disabled() // TODO : lockable
            ->schema([
                Forms\Components\FileUpload::make('foto')
                    ->label('Photo')
                    ->downloadable()
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
                    ->unique(
                        table: 'calon_peserta_didik',
                        column: 'nisn',
                        ignorable: fn () => $this->calonPesertaDidik,
                    )
                    ->length(10)
                    ->required(),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->default('Indonesia')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->unique(
                        table: 'calon_peserta_didik',
                        column: 'nik',
                        ignorable: fn () => $this->calonPesertaDidik,
                    )
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('kk')
                    ->label('Nomor KK')
                    ->required()
                    ->length(16),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('no_reg_akta')
                    ->label('No. Reg Akta')
                    ->maxLength(255),
                Forms\Components\Select::make('agama_id')
                    ->required()
                    ->label('Agama')
                    ->options(Agama::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('berkebutuhan_khusus_id')
                    ->label('Berkebutuhan Khusus')
                    ->options(BerkebutuhanKhusus::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('alamat')
                    ->required()
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
                    ->label('Desa/Kelurahan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kabupaten_kota')
                    ->label('Kabupaten/Kota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lintang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bujur')
                    ->maxLength(255),
                Forms\Components\Select::make('tempat_tinggal_id')
                    ->required()
                    ->label('Tempat Tinggal')
                    ->options(TempatTinggal::pluck('nama', 'id')),
                Forms\Components\Select::make('moda_transportasi_id')
                    ->required()
                    ->label('Moda Transportasi')
                    ->options(ModaTransportasi::pluck('nama', 'id')),
                Forms\Components\TextInput::make('anak_ke')
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_hp')
                    ->required()
                    ->label('Nomor HP (Aktif Whatsapp)')
                    ->maxLength(16),
                Forms\Components\TextInput::make('nomor_hp_ortu')
                    ->label('Nomor HP Orang Tua (Aktif Whatsapp)')
                    ->maxLength(16),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('asal_sekolah_id')
                    ->label('Pilih Asal Sekolah')
                    ->options(AsalSekolah::pluck('nama', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('asal_sekolah_temp')
                    ->label('Asal Sekolah')
                    ->placeholder('Ketik nama sekolah disini jika tidak ditemukan pada daftar. Kosongkan jika sudah ditemukan!')
            ])
            ->columns(2)
            ->statePath('cpd');
    }

    public function handleSubmit(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $cpd = $this->calonPesertaDidikForm->getState();

            $this->calonPesertaDidik->update($cpd);

            Notification::make()->title('Biodata Berhasil disimpan!')->success()->send();
            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.biodata-component');
    }
}
