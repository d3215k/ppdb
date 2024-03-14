<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Models\AsalSekolah;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use App\Models\TahunPelajaran;
use App\Models\User;
use App\Support\GenerateNumber;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Unique;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PendaftaranBaruComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    #[Computed()]
    public function calonPesertaDidik()
    {
        return CalonPesertaDidik::find(auth()->user()->calon_peserta_didik_id);
    }

    public function mount(): void
    {
        $this->form->fill(
            $this->calonPesertaDidik()?->toArray()
        );
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
                                ->maxLength(255),
                            Forms\Components\ToggleButtons::make('lp')
                                ->inline()
                                ->label('Jenis Kelamin')
                                ->options(JenisKelamin::class)
                                ->required()
                                ,
                            Forms\Components\TextInput::make('nisn')
                                // ->required()
                                ->label('NISN')
                                ->unique(
                                    table: 'calon_peserta_didik',
                                    column: 'nisn',
                                    ignorable: fn () => $this->calonPesertaDidik(),
                                    modifyRuleUsing: function (Unique $rule) {
                                        return $rule->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
                                    }
                                )
                                ->validationMessages([
                                    'unique' => 'NISN sudah terdaftar.',
                                ])
                                ->maxLength(10),
                            Forms\Components\TextInput::make('nik')
                                ->label('NIK')
                                // ->required()
                                ->unique(
                                    table: 'calon_peserta_didik',
                                    column: 'nik',
                                    ignorable: fn () => $this->calonPesertaDidik(),
                                    modifyRuleUsing: function (Unique $rule) {
                                        return $rule->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
                                    }
                                )
                                ->validationMessages([
                                    'unique' => 'NIK sudah terdaftar.',
                                ])
                                ->maxLength(16),
                            Forms\Components\TextInput::make('tempat_lahir')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\DatePicker::make('tanggal_lahir')
                                // ->required()
                                ,
                                Forms\Components\TextInput::make('alamat')
                                ->label('Alamat Rumah')
                                // ->required()
                                ->columnSpanFull()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('rt')
                                ->label('RT')
                                ->nullable()
                                ->numeric(),
                            Forms\Components\TextInput::make('rw')
                                ->label('RW')
                                ->nullable()
                                ->numeric(),
                            Forms\Components\TextInput::make('desa_kelurahan')
                                ->label('Desa/Kelurahan')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kecamatan')
                                ->label('Kecamatan')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kabupaten_kota')
                                ->label('Kabupaten/kota')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('provinsi')
                                ->label('Provinsi')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kabupaten_kota')
                                ->label('kabupaten_kota')
                                // ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kode_pos')
                                // ->nullable()
                                ->numeric(),
                            Forms\Components\TextInput::make('ibu')
                                ->label('Nama Ibu')
                                // ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('ayah')
                                ->label('Nama Ayah')
                                // ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('nomor_hp')
                                ->label('Nomor HP (Aktif WA)')
                                // ->required()
                                ->maxLength(16),
                            Forms\Components\TextInput::make('nomor_hp_ortu')
                                ->label('Nomor HP Orang Tua (Aktif WA)')
                                // ->required()
                                ->maxLength(16),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                // ->required()
                                ->maxLength(255)
                                ->default(auth()->user()->email),
                        ]),
                    Wizard\Step::make('Asal Sekolah')
                        ->schema([
                            Forms\Components\Select::make('asal_sekolah_id')
                                ->label('Asal Sekolah')
                                ->options(AsalSekolah::pluck('nama', 'id'))
                                ->preload()
                                // ->required()
                                ->searchable(),
                        ]),
                    Wizard\Step::make('Gelombang dan Jalur Pendaftaran')
                        ->schema([
                            ToggleButtons::make('gelombang_id')
                                ->label('Gelombang Pendaftaran')
                                ->options(
                                    function () {
                                        return Gelombang::query()
                                            ->aktifDibuka()
                                            ->pluck('nama', 'id');
                                    }
                                )
                                ->inline()
                                // ->required()
                                ->reactive(),
                            ToggleButtons::make('jalur_id')
                                ->label('Jalur Pendaftaran')
                                ->inline()
                                ->options(fn (Get $get): Collection => Jalur::query()
                                    ->whereHas('gelombang', fn ($query) => $query->where('gelombang_id', $get('gelombang_id')))
                                    ->pluck('nama', 'id')
                                )
                                // ->required()
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('gelombang_id')),
                        ]),
                    Wizard\Step::make('Pilihan Kompetensi Keahlian')
                        ->schema([
                            ToggleButtons::make('pilihan_kesatu')
                                ->label('Pilihan Kompetensi Keahlian Pertama')
                                ->options(fn (): Collection => KompetensiKeahlian::query()
                                    ->where('dipilih_kesatu', true)
                                    ->pluck('nama', 'id')
                                )
                                ->inline()
                                // ->required()
                                ->reactive(),
                            ToggleButtons::make('pilihan_kedua')
                                ->label('Pilihan Kompetensi Keahlian Kedua')
                                ->options(fn (Get $get): Collection => KompetensiKeahlian::query()
                                    ->where('dipilih_kedua', true)
                                    ->whereNot('id', $get('pilihan_kesatu'))
                                    ->pluck('nama', 'id')
                                )
                                ->inline()
                                // ->required()
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kesatu')),
                        ]),
                        // TODO : Halaman Konfirmasi
                        // Demikian data di atas adalah data sebenarnya dan dapat dipertanggungjawabkan, jika data tersebut tidak sesuai dengan sebenarnya, kami siap menerima sanksi sesuai dengan ketentuan yang berlaku.
                    ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            wire:click="handleSubmit"
                            size="sm"
                        >
                            Submit
                        </x-filament::button>
                    BLADE))),
            ])
            ->statePath('data');
    }

    public function handleSubmit()
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();

            $payload = [
                'nama' => $data['nama'],
                'lp' => $data['lp'],
                'nisn' => $data['nisn'],
                'nik' => $data['nik'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'rt' => $data['rt'],
                'rw' => $data['rw'],
                'desa_kelurahan' => $data['desa_kelurahan'],
                'kode_pos' => $data['kode_pos'],
                'nomor_hp' => $data['nomor_hp'],
                'nomor_hp_ortu' => $data['nomor_hp_ortu'],
                'email' => $data['email'],
                'asal_sekolah_id' => $data['asal_sekolah_id'],
            ];

            if (!isset(auth()->user()->calon_peserta_didik_id)) {
                $cpd = CalonPesertaDidik::create($payload);

                User::where('id', auth()->id())->update([
                    'calon_peserta_didik_id' => $cpd->id
                ]);

            } else {
                $cpd = CalonPesertaDidik::updateOrCreate(
                    [
                        'id' => auth()->user()->calon_peserta_didik_id,
                    ],
                    $payload
                );
            }

            $cpd->ayah()->updateOrCreate([
                'nama' => $data['ayah']
            ]);

            $cpd->ibu()->updateOrCreate([
                'nama' => $data['ibu']
            ]);

            $cpd->rapor()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->periodik()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $cpd->persyaratanUmum()->updateOrCreate([
                'calon_peserta_didik_id' => $cpd->id
            ]);

            $tahun = TahunPelajaran::whereAktif(true)->first();
            $gelombang = Gelombang::find($data['gelombang_id']);
            $data['tahun_pelajaran_id'] = $tahun->id;
            $data['nomor'] = GenerateNumber::pendaftaran($tahun, $gelombang);

            Pendaftaran::updateOrCreate(
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

            if ($cpd) {
                session([
                    'hasCalonPesertaDidik' => true,
                ]);
            }

            Notification::make()->title('berhasil')->success()->send();
            DB::commit();
            return to_route('pendaftar.dashboard');
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
