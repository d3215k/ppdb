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
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tahun_pelajaran_id', TahunPelajaran::first()->id)
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
                Forms\Components\Section::make('Biodata')
                    ->collapsible()
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
                        Forms\Components\TextInput::make('address')
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
                            ])
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
                    ->description(fn (Pendaftaran $record) => $record->calonPesertaDidik->asalSekolah->nama)
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
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gelombang_id')
                    ->options(Gelombang::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('jalur_id')
                    ->options(Jalur::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('Asal Sekolah')
                    ->relationship('calonPesertaDidik.asalSekolah', 'nama')
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
            ->filtersFormColumns(4);
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
