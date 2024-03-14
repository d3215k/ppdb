<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Enums\StatusPendaftaran;
use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use App\Models\TahunPelajaran;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Panitia';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'calonPesertaDidik',
                'calonPesertaDidik.asalSekolah',
                'jalur',
                'pilihanKesatu',
                'pilihanKedua',
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calon_peserta_didik_id')
                    ->relationship(
                        name: 'calonPesertaDidik',
                        titleAttribute: 'nama'
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('jalur_id')
                    ->relationship('jalur', 'nama')
                    ->required(),
                Forms\Components\Select::make('gelombang_id')
                    ->relationship('gelombang', 'nama')
                    ->required(),
                Forms\Components\Select::make('pilihan_kesatu')
                    ->options(KompetensiKeahlian::where('dipilih_kesatu', true)->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('pilihan_kedua')
                    ->options(KompetensiKeahlian::where('dipilih_kedua', true)->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\ToggleButtons::make('status')
                    ->options(StatusPendaftaran::class)
                    ->inline()
                    ->hiddenOn('create')
                    ->columnSpanFull(),
                Forms\Components\Section::make('Biodata')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->hiddenOn('create')
                    ->relationship('calonPesertaDidik')
                    ->schema([
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
                            ->relationship('agama', 'nama')
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('berkebutuhan_khusus_id')
                            ->relationship('berkebutuhanKhusus', 'nama')
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
                        Forms\Components\TextInput::make('kode_pos')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('lintang')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bujur')
                            ->maxLength(255),
                        Forms\Components\Select::make('tempat_tinggal_id')
                            ->relationship('tempatTinggal', 'nama'),
                        Forms\Components\Select::make('moda_transportasi_id')
                            ->relationship('modaTransportasi', 'nama'),
                        Forms\Components\TextInput::make('anak_ke')
                            ->numeric(),
                        Forms\Components\TextInput::make('nomor_hp')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Select::make('asal_sekolah_id')
                            ->relationship('asalSekolah', 'nama')
                            ->preload()
                            ->searchable(),
                        Forms\Components\Fieldset::make('Akun PPDB Dinas')
                            ->schema([
                                Forms\Components\TextInput::make('username')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('password')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Section::make('Rapor')
                            ->collapsible()
                            ->collapsed()
                            ->columns(2)
                            ->hiddenOn('create')
                            ->relationship('rapor')
                            ->schema([
                                Forms\Components\FileUpload::make('halaman_identitas'),
                                Forms\Components\FileUpload::make('halaman_nilai_semester'),
                                Forms\Components\Fieldset::make('pai')
                                    ->label('Pendidikan Agama Islam')
                                    ->schema([
                                        Forms\Components\TextInput::make('pai_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('pai_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('pai_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('pai_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('pai_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\Fieldset::make('bindo')
                                    ->label('Bahasa Indonesia')
                                    ->schema([
                                        Forms\Components\TextInput::make('bindo_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bindo_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bindo_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bindo_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bindo_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\Fieldset::make('mtk')
                                    ->label('Matematika')
                                    ->schema([
                                        Forms\Components\TextInput::make('mtk_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('mtk_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('mtk_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('mtk_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('mtk_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\Fieldset::make('ipa')
                                    ->label('Ilmu Pengetahuan Alam')
                                    ->schema([
                                        Forms\Components\TextInput::make('ipa_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ipa_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ipa_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ipa_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ipa_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\Fieldset::make('ips')
                                    ->label('Ilmu Pengetahuan Sosial')
                                    ->schema([
                                        Forms\Components\TextInput::make('ips_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ips_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ips_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ips_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('ips_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\Fieldset::make('bing')
                                    ->label('Bahasa Inggris')
                                    ->schema([
                                        Forms\Components\TextInput::make('bing_1')
                                            ->label('Sem. I')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bing_2')
                                            ->label('Sem. II')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bing_3')
                                            ->label('Sem. III')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bing_4')
                                            ->label('Sem. IV')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('bing_5')
                                            ->label('Sem. V')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(5),
                                Forms\Components\FileUpload::make('halaman_kehadiran'),
                                Forms\Components\Fieldset::make('Jumlah Ketidakhadiran')
                                    ->schema([
                                        Forms\Components\TextInput::make('sakit')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('izin')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                        Forms\Components\TextInput::make('alpa')
                                            ->numeric()
                                            ->maxValue(100)
                                            ->minValue(0),
                                    ])
                                    ->columns(3),
                            ]),
                    ]),

                Forms\Components\Section::make('Persyaratan Umum')
                    ->collapsible()
                    ->collapsed()
                    ->hiddenOn('create')
                    ->columns(2)
                    ->relationship('persyaratanUmum')
                    ->schema([
                        Forms\Components\FileUpload::make('dokumen_kelulusan'),
                        Forms\Components\FileUpload::make('dokumen_kelahiran'),
                        Forms\Components\FileUpload::make('kartu_keluarga'),
                        Forms\Components\FileUpload::make('ktp_ortu'),
                        Forms\Components\Toggle::make('status_kelulusan_sekolah_asal')
                            ->inline(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->label('Nama / Asal Sekolah')
                    ->description(fn (Pendaftaran $record) => $record->calonPesertaDidik->asalSekolah?->nama)
                    ->sortable(),
                Tables\Columns\TextColumn::make('gelombang.nama')
                    ->label('Gelombang / Jalur')
                    ->description(fn (Pendaftaran $record) => $record->jalur->nama)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pilihanKesatu.kode')
                    ->label('Pilihan Kesatu dan Kedua')
                    ->description(fn (Pendaftaran $record) => $record->pilihanKedua->kode)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gelombang_id')
                    ->label('Gelombang')
                    ->options(Gelombang::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('jalur_id')
                    ->label('Jalur')
                    ->options(Jalur::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('Asal Sekolah')
                    ->relationship('calonPesertaDidik.asalSekolah', 'nama')
                    ->searchable()
                    ->options(AsalSekolah::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('pilihan_kesatu')
                    ->options(KompetensiKeahlian::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('pilihan_kedua')
                    ->options(KompetensiKeahlian::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('status')
                    ->options(StatusPendaftaran::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(3);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BuktiPersyaratanKhususRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }
}
