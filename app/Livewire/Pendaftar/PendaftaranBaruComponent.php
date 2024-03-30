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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
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
        return CalonPesertaDidik::where('id', auth()->user()->calon_peserta_didik_id)
            ->select('id', 'nama','lp','nisn','nik','tempat_lahir','tanggal_lahir','alamat','rt','rw','desa_kelurahan','kecamatan','kabupaten_kota','provinsi','kode_pos','nomor_hp','nomor_hp_ortu','email','asal_sekolah_id')
            ->first();
    }

    public function mount(): void
    {
        $this->calonPesertaDidik?->load('ortu:id,calon_peserta_didik_id,nama_ibu,nama_ayah');

        $payload = [
            'email' => auth()->user()->email,
            'nama' => auth()->user()->name,
        ];

        if ($this->calonPesertaDidik) {
            $payload = [
                ...$payload,
                'ibu' => $this->calonPesertaDidik->ortu->nama_ibu,
                'ayah' => $this->calonPesertaDidik->ortu->nama_ayah,
                ...$this->calonPesertaDidik->toArray(),
            ];
        }

        $this->form->fill($payload);
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
                                ->required()
                                ->label('NISN')
                                ->unique(
                                    table: 'calon_peserta_didik',
                                    column: 'nisn',
                                    ignorable: fn () => $this->calonPesertaDidik,
                                    modifyRuleUsing: function (Unique $rule) {
                                        return $rule->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
                                    }
                                )
                                ->validationMessages([
                                    'unique' => 'NISN sudah terdaftar.',
                                    'required' => 'NISN wajib diisi.'
                                ])
                                ->maxLength(10)
                                ->minLength(10),
                            Forms\Components\TextInput::make('nik')
                                ->label('NIK')
                                ->required()
                                ->unique(
                                    table: 'calon_peserta_didik',
                                    column: 'nik',
                                    ignorable: fn () => $this->calonPesertaDidik,
                                    modifyRuleUsing: function (Unique $rule) {
                                        return $rule->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
                                    }
                                )
                                ->validationMessages([
                                    'unique' => 'NIK sudah terdaftar.',
                                    'required' => 'NIK wajib diisi.'
                                ])
                                ->maxLength(16)
                                ->minLength(16),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\DatePicker::make('tanggal_lahir')
                                ->required()
                                ,
                            Forms\Components\TextInput::make('alamat')
                                ->label('Alamat Rumah')
                                ->required()
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
                                ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kecamatan')
                                ->label('Kecamatan')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kabupaten_kota')
                                ->label('Kabupaten/kota')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('provinsi')
                                ->label('Provinsi')
                                ->required()
                                ->maxLength(126),
                            Forms\Components\TextInput::make('kode_pos')
                                // ->nullable()
                                ->numeric(),
                            Forms\Components\TextInput::make('ibu')
                                ->label('Nama Ibu')
                                ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('ayah')
                                ->label('Nama Ayah')
                                ->required()
                                ->maxLength(128),
                            Forms\Components\TextInput::make('nomor_hp')
                                ->label('Nomor HP (Aktif WA)')
                                ->required()
                                ->minLength(6)
                                ->maxLength(16),
                            Forms\Components\TextInput::make('nomor_hp_ortu')
                                ->label('Nomor HP Orang Tua (Aktif WA)')
                                ->required()
                                ->minLength(6)
                                ->maxLength(16),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                        ]),
                    Wizard\Step::make('Asal Sekolah')
                        ->schema([
                            Forms\Components\Select::make('asal_sekolah_id')
                                ->label('Cari dan Pilih Asal Sekolah')
                                ->options(AsalSekolah::pluck('nama', 'id'))
                                ->preload()
                                // ->required()
                                ->searchable(),
                            Forms\Components\TextInput::make('asal_sekolah_temp')
                                ->label('Asal Sekolah')
                                ->placeholder('Ketik nama sekolah disini jika tidak ditemukan pada daftar. Kosongkan jika sudah ditemukan!')
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
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $set('jalur_id', null);
                                }),
                            ToggleButtons::make('jalur_id')
                                ->label('Jalur Pendaftaran')
                                ->inline()
                                ->options(fn (Get $get): Collection => Jalur::query()
                                    ->whereHas('gelombang', fn ($query) => $query->where('gelombang_id', $get('gelombang_id')))
                                    ->pluck('nama', 'id')
                                )
                                ->required()
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
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    if ($state === $get('pilihan_kedua')) {
                                        $set('pilihan_kedua', null);
                                    }
                                }),
                            ToggleButtons::make('pilihan_kedua')
                                ->label('Pilihan Kompetensi Keahlian Kedua')
                                ->options(fn (Get $get): Collection => KompetensiKeahlian::query()
                                    ->where('dipilih_kedua', true)
                                    ->whereNot('id', $get('pilihan_kesatu'))
                                    ->pluck('nama', 'id')
                                )
                                ->inline()
                                ->required()
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kesatu')),
                        ]),
                    Wizard\Step::make('Konfirmasi Data')
                        ->schema([
                            Fieldset::make('confirm_biodata')
                                ->label('Biodata')
                                ->schema([
                                    Placeholder::make('confirm_nama')
                                        ->label('Nama')
                                        ->content(function (Get $get): ?string {
                                            return $get('nama');
                                        }),
                                    Placeholder::make('confirm_lp')
                                        ->label('Jenis Kelamin')
                                        ->content(function (Get $get): ?string {
                                            return JenisKelamin::tryFrom($get('lp'))->getLabel();
                                        }),
                                    Placeholder::make('confirm_nisn')
                                        ->label('NISN')
                                        ->content(function (Get $get): ?string {
                                            return $get('nisn');
                                        }),
                                    Placeholder::make('confirm_nik')
                                        ->label('NIK')
                                        ->content(function (Get $get): ?string {
                                            return $get('nik');
                                        }),
                                    Placeholder::make('confirm_tempat_lahir')
                                        ->label('Tempat Lahir')
                                        ->content(function (Get $get): ?string {
                                            return $get('tempat_lahir');
                                        }),
                                    Placeholder::make('confirm_tanggal_lahir')
                                        ->label('Tanggal Lahir')
                                        ->content(function (Get $get): ?string {
                                            return $get('tanggal_lahir');
                                        }),
                                    Placeholder::make('confirm_alamat')
                                        ->label('Alamat')
                                        ->content(function (Get $get): ?string {
                                            return $get('alamat').' RT '.$get('rt').' RW '.$get('rw').' Desa/Kelurahan '.$get('desa_kelurahan').' Kec. '.$get('kecamatan').' Kab/Kota '.$get('kabupaten_kota').' '.$get('privinsi').' '.$get('kode_pos');
                                        }),
                                    Placeholder::make('confirm_ibu')
                                        ->label('Nama Ibu')
                                        ->content(function (Get $get): ?string {
                                            return $get('ibu');
                                        }),
                                    Placeholder::make('confirm_ayah')
                                        ->label('Nama Ayah')
                                        ->content(function (Get $get): ?string {
                                            return $get('ayah');
                                        }),
                                    Placeholder::make('confirm_nomor_hp')
                                        ->label('Nomor Hp (Aktif WA)')
                                        ->content(function (Get $get): ?string {
                                            return $get('nomor_hp');
                                        }),
                                    Placeholder::make('confirm_nomor_hp_ortu')
                                        ->label('Nomor HP Orang Tua (Aktif WA)')
                                        ->content(function (Get $get): ?string {
                                            return $get('nomor_hp_ortu');
                                        }),
                                    Placeholder::make('confirm_email')
                                        ->label('Email')
                                        ->content(function (Get $get): ?string {
                                            return $get('email');
                                        }),
                                    ])
                                    ->reactive()
                                    ->hidden(fn (Get $get): bool => ! $get('pilihan_kedua')),

                            Fieldset::make('confirm_asal_sekolah')
                                ->label('Asal Sekolah')
                                ->schema([
                                    Placeholder::make('confirm_asal_sekolah_id')
                                        ->label('Nama Sekolah')
                                        ->content(function (Get $get): ?string {
                                            if ($get('asal_sekolah_id')) {
                                                return AsalSekolah::where('id', $get('asal_sekolah_id'))->select('nama')->first()?->nama;
                                            } else {
                                                return $get('asal_sekolah_temp');
                                            }
                                        })
                                ])
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kedua')),

                            Fieldset::make('confirm_gelombang')
                                ->label('Gelombang dan Jalur')
                                ->schema([
                                    Placeholder::make('confirm_gelombang_id')
                                        ->label('Gelombang')
                                        ->content(function (Get $get): ?string {
                                            return Gelombang::where('id', $get('gelombang_id'))->select('nama')->first()?->nama;
                                        }),
                                    Placeholder::make('confirm_jalur_id')
                                        ->label('Jalur')
                                        ->content(function (Get $get): ?string {
                                            return Jalur::where('id', $get('jalur_id'))->select('nama')->first()?->nama;
                                        }),
                                ])
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kedua')),

                            Fieldset::make('confirm_pilihan_kompetensi_keahlian')
                                ->label('Pilihan Kompetensi Keahlian')
                                ->schema([
                                    Placeholder::make('confirm_pilihan_kesatu')
                                        ->label('Pilihan Pertama')
                                        ->content(function (Get $get): ?string {
                                            return KompetensiKeahlian::where('id', $get('pilihan_kesatu'))->select('nama')->first()?->nama;
                                        }),
                                    Placeholder::make('confirm_pilihan_kedua')
                                        ->label('Pilihan Kedua')
                                        ->content(function (Get $get): ?string {
                                            return KompetensiKeahlian::where('id', $get('pilihan_kedua'))->select('nama')->first()?->nama;
                                        }),
                                ])
                                ->reactive()
                                ->hidden(fn (Get $get): bool => ! $get('pilihan_kedua')),

                            Checkbox::make('confirm')
                                ->accepted()
                                ->validationAttribute('Konfirmasi')
                                ->columnSpanFull()
                                ->label('Demikian data di atas adalah data sebenarnya dan dapat dipertanggungjawabkan, jika data tersebut tidak sesuai dengan sebenarnya, kami siap menerima sanksi sesuai dengan ketentuan yang berlaku.')
                        ])->columns(2)
                    ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            wire:click="handleSubmit"
                            size="sm"
                        >
                            Submit Formulir
                        </x-filament::button>
                    BLADE))),
            ])
            ->statePath('data');
    }

    public function handleSubmit()
    {
        $this->validate();

        DB::beginTransaction();

        try {
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
                'kecamatan' => $data['kecamatan'],
                'kabupaten_kota' => $data['kabupaten_kota'],
                'provinsi' => $data['provinsi'],
                'kode_pos' => $data['kode_pos'],
                'nomor_hp' => $data['nomor_hp'],
                'nomor_hp_ortu' => $data['nomor_hp_ortu'],
                'email' => $data['email'],
                'asal_sekolah_id' => $data['asal_sekolah_id'],
                'asal_sekolah_temp' => $data['asal_sekolah_temp'],
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

            $cpd->ortu()->updateOrCreate(
                [
                    'calon_peserta_didik_id' => $cpd->id
                ],
                [
                    'nama_ayah' => $data['ayah'],
                    'nama_ibu' => $data['ibu'],
                ]
            );

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

            Notification::make()->title('Pendaftaran Berhasil!')->success()->send();

            DB::commit();

            return to_route('pendaftar.dashboard');

        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.pendaftaran-baru-component');
    }
}
