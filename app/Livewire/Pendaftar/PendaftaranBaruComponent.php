<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\ModaTransportasi;
use App\Models\Pendaftaran;
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
use Livewire\Component;

class PendaftaranBaruComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Biodata')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('nama')
                                ->label('Nama Lengkap')
                                ->required()
                                ->default(auth()->user()->name)
                                ->maxLength(255),
                            Forms\Components\ToggleButtons::make('lp')
                                ->inline()
                                ->label('L/P')
                                ->options(JenisKelamin::class)
                                ->required()
                                ,
                            Forms\Components\TextInput::make('nisn')
                                ->required()
                                ->label('NISN')
                                ->maxLength(10),
                            Forms\Components\TextInput::make('nik')
                                ->label('NIK')
                                ->required()
                                ->maxLength(16),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\DatePicker::make('tanggal_lahir')
                                ->required(),
                            Forms\Components\TextInput::make('ibu')
                                ->label('Nama Ibu')
                                ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('ayah')
                                ->label('Nama Ayah')
                                ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('address')
                                ->label('Alamat Rumah')
                                ->required()
                                ->columnSpanFull()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('rt')
                                ->label('RT')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('rw')
                                ->label('RW')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('dusun')
                                ->nullable()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('desa_kelurahan')
                                ->label('Desa/Kelurahan')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kode_pos')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('nomor_hp')
                                ->label('Nomor HP (Aktif WA)')
                                ->required()
                                ->maxLength(16),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->default(auth()->user()->email),
                        ]),
                    Wizard\Step::make('Asal Sekolah')
                        ->schema([
                            Forms\Components\Select::make('asal_sekolah_id')
                                ->label('Asal Sekolah')
                                ->options(AsalSekolah::pluck('nama', 'id'))
                                ->preload()
                                ->required()
                                ->searchable(),
                        ]),
                    Wizard\Step::make('Gelombang dan Jalur Pendaftaran')
                        ->schema([
                            Select::make('gelombang_id')
                                ->label('Gelombang Pendaftaran')
                                ->options(
                                    function () {
                                        return Gelombang::pluck('nama', 'id');
                                    }
                                )
                                ->searchable()
                                ->preload()
                                ->required()
                                ->reactive(),
                            Select::make('jalur_id')
                                ->label('Jalur Pendaftaran')
                                ->options(fn (Get $get): Collection => Jalur::query()
                                    // ->where('skema_id', $get('skema_id'))
                                    ->pluck('nama', 'id')
                                )
                                ->required()
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('gelombang_id')),
                        ]),
                    Wizard\Step::make('Pilihan Kompetensi Keahlian')
                        ->schema([
                            Select::make('pilihan_kesatu')
                                ->label('Pilihan Kompetensi Keahlian Pertama')
                                ->options(fn (): Collection => KompetensiKeahlian::query()
                                    ->where('dipilih_kesatu', true)
                                    ->pluck('nama', 'id')
                                )
                                ->required()
                                ->reactive(),
                            Select::make('pilihan_kedua')
                                ->label('Pilihan Kompetensi Keahlian Kedua')
                                ->options(fn (Get $get): Collection => KompetensiKeahlian::query()
                                    ->where('dipilih_kedua', true)
                                    ->whereNot('id', $get('pilihan_kesatu'))
                                    ->pluck('nama', 'id')
                                )
                                ->required()
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kesatu')),
                        ]),
                    ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            type="submit"
                            size="sm"
                        >
                            Submit
                        </x-filament::button>
                    BLADE))),
            ])
            ->statePath('data');
    }

    public function handleSubmit(): void
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();

            $cpd = CalonPesertaDidik::updateOrCreate(
                [
                    'id' => auth()->user()->calon_peserta_didik_id,
                ],
                [
                    'nama' => $data['nama'],
                    'lp' => $data['lp'],
                    'nisn' => $data['nisn'],
                    'nik' => $data['nik'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'address' => $data['address'],
                    'rt' => $data['rt'],
                    'rw' => $data['rw'],
                    'desa_kelurahan' => $data['desa_kelurahan'],
                    'kode_pos' => $data['kode_pos'],
                    'nomor_hp' => $data['nomor_hp'],
                    'email' => $data['email'],
                    'asal_sekolah_id' => $data['asal_sekolah_id'],
                ]
            );

            $cpd->ayah()->updateOrCreate([
                'nama' => $data['ayah']
            ]);

            $cpd->ibu()->updateOrCreate([
                'nama' => $data['ibu']
            ]);

            $tahun = TahunPelajaran::whereAktif(true)->first();
            $gelombang = Gelombang::find($data['gelombang_id']);
            $data['tahun_pelajaran_id'] = $tahun->id;
            $data['nomor'] = GenerateNumber::pendaftaran($tahun, $gelombang);

            $pendaftaran = Pendaftaran::updateOrCreate(
                [
                    'tahun_pelajaran_id' => $tahun->id,
                    'calon_peserta_didik_id' => $cpd->id,
                    'gelombang_id' => $data['gelombang_id'],
                ],
                [
                    'jalur_id' => $data['jalur_id'],
                    'nomor' => $data['nomor'],
                    'pilihan_kesatu' => $data['pilihan_kesatu'],
                    'pilihan_kedua' => $data['pilihan_kedua'],
                ]
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
        return view('livewire.pendaftar.pendaftaran-baru-component');
    }
}
