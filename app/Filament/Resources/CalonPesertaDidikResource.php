<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\CalonPesertaDidikResource\Pages;
use App\Filament\Resources\CalonPesertaDidikResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalonPesertaDidikResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = CalonPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Panitia';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Asal Sekolah')
                    ->schema([
                        Forms\Components\Select::make('asal_sekolah_id')
                            ->label('Pilih Asal Sekolah')
                            ->relationship('asalSekolah', 'nama')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Sekolah')
                                    ->required(),
                                Forms\Components\TextInput::make('npsn')
                                    ->label('NPSN')
                                    ->nullable(),
                                Forms\Components\TextInput::make('alamat')
                                    ->nullable(),
                            ])
                            ->preload()
                            ->searchable(),
                        Forms\Components\TextInput::make('asal_sekolah_temp')
                            ->label('Asal Sekolah')
                            ->placeholder('Kosongkan jika sudah ada di daftar!')
                            ->hiddenOn('create'),
                    ]),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->maxSize(512)
                    ->columnSpanFull()
                    ->hiddenOn('create'),
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
                    ->maxLength(255)
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->maxLength(16),
                Forms\Components\TextInput::make('kk')
                    ->label('Nomor KK')
                    ->maxLength(16)
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('no_reg_akta')
                    ->maxLength(255),
                Forms\Components\Select::make('agama_id')
                    ->relationship('agama', 'nama')
                    ->preload()
                    ->searchable()
                    ->hiddenOn('create'),
                Forms\Components\Select::make('berkebutuhan_khusus_id')
                    ->relationship('berkebutuhanKhusus', 'nama')
                    ->preload()
                    ->searchable()
                    ->hiddenOn('create'),
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
                Forms\Components\TextInput::make('kecamatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kabupaten_kota')
                    ->label('Kabupaten/Kota')
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lintang')
                    ->maxLength(255)
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('bujur')
                    ->maxLength(255)
                    ->hiddenOn('create'),
                Forms\Components\Select::make('tempat_tinggal_id')
                    ->relationship('tempatTinggal', 'nama')
                    ->hiddenOn('create'),
                Forms\Components\Select::make('moda_transportasi_id')
                    ->relationship('modaTransportasi', 'nama')
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('anak_ke')
                    ->hiddenOn('create')
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_hp')
                    ->label('Nomor HP (Aktif Whatsapp)')
                    ->maxLength(16),
                Forms\Components\TextInput::make('nomor_hp_ortu')
                    ->label('Nomor HP Orang Tua (Aktif Whatsapp)')
                    ->maxLength(16),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->label('Asal Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendaftaran_count')
                    ->label('Pendaftaran')
                    ->counts('pendaftaran'),
                Tables\Columns\ToggleColumn::make('locked')
                    ->tooltip('Kunci edit data oleh pendaftar?'),
            ])
            ->filters([
                SelectFilter::make('Gelombang')
                    ->options(
                        fn() => Gelombang::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'pendaftaran',
                                fn (Builder $query) => $query->where('gelombang_id', '=', (int) $data['value'])
                            );
                        }
                    }),
                SelectFilter::make('Jalur')
                    ->options(
                        fn() => Jalur::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'pendaftaran',
                                fn (Builder $query) => $query->where('jalur_id', '=', (int) $data['value'])
                            );
                        }
                    }),
                SelectFilter::make('Asal Sekolah')
                    ->options(
                        fn() => AsalSekolah::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->where('asal_sekolah_id', '=', (int) $data['value']);
                        }
                    }),
                SelectFilter::make('Pilihan Kesatu')
                    ->options(
                        fn() => KompetensiKeahlian::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'pendaftaran',
                                fn (Builder $query) => $query->where('pilihan_kesatu', '=', (int) $data['value'])
                            );
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('Whatsapp')
                    ->label(fn (CalonPesertaDidik $record) => $record->nomor_hp)
                    ->url(fn (CalonPesertaDidik $record) => $record->getWhatsappLink())
                    ->icon('heroicon-m-chat-bubble-left')
                    ->openUrlInNewTab()
                    ->hidden(fn (CalonPesertaDidik $record) => ! $record->nomor_hp),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Locked')
                    // ->icon('heroicon-m-user')
                    ->action(function (Collection $records, array $data): void {
                        try {
                            foreach ($records as $record) {
                                $record->locked = $data['locked'];
                                $record->save();
                            }
                            Notification::make()->title('Data Locked berhasil diatur!')->success()->send();
                        } catch (\Throwable $th) {
                            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                            report($th->getMessage());
                        }

                    })
                    ->form([
                        Forms\Components\ToggleButtons::make('locked')
                            ->label('Kunci edit data oleh Pendaftar?')
                            ->boolean()
                            ->grouped()
                    ])
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('nama')
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(2);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditCalonPesertaDidik::class,
            Pages\OrtuCalonPesertaDidik::class,
            Pages\DataPeriodikCalonPesertaDidik::class,
            Pages\RaporCalonPesertaDidik::class,
            Pages\HasilTesCalonPesertaDidik::class,
            Pages\PersyaratanUmumCalonPesertaDidik::class,
            Pages\PendaftaranCalonPesertaDidik::class,
            Pages\UserCalonPesertaDidik::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalonPesertaDidiks::route('/'),
            'create' => Pages\CreateCalonPesertaDidik::route('/create'),
            'edit' => Pages\EditCalonPesertaDidik::route('/{record}/edit'),
            'periodik' => Pages\DataPeriodikCalonPesertaDidik::route('/{record}/periodik'),
            'ortu' => Pages\OrtuCalonPesertaDidik::route('/{record}/ortu'),
            'rapor' => Pages\RaporCalonPesertaDidik::route('/{record}/rapor'),
            'tes' => Pages\HasilTesCalonPesertaDidik::route('/{record}/tes'),
            'persyaratanUmum' => Pages\PersyaratanUmumCalonPesertaDidik::route('/{record}/persyaratan-umum'),
            'pendaftaran' => Pages\PendaftaranCalonPesertaDidik::route('/{record}/pendaftaran'),
            'user' => Pages\UserCalonPesertaDidik::route('/{record}/user'),
        ];
    }
}
