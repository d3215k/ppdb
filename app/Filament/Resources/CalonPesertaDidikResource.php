<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\CalonPesertaDidikResource\Pages;
use App\Filament\Resources\CalonPesertaDidikResource\RelationManagers;
use App\Models\CalonPesertaDidik;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                Forms\Components\FileUpload::make('foto')
                    ->image()
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
                    ])
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
                Tables\Columns\ToggleColumn::make('locked'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Whatsapp')
                    ->url(fn (CalonPesertaDidik $record) => $record->getWhatsappLink())
                    ->icon('heroicon-m-chat-bubble-left')
                    ->openUrlInNewTab()
                    ->hidden(fn (CalonPesertaDidik $record) => ! $record->nomor_hp),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            Pages\PersyaratanUmumCalonPesertaDidik::class,
            Pages\PendaftaranCalonPesertaDidik::class,
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
            'persyaratanUmum' => Pages\PersyaratanUmumCalonPesertaDidik::route('/{record}/persyaratan-umum'),
            'pendaftaran' => Pages\PendaftaranCalonPesertaDidik::route('/{record}/pendaftaran'),
        ];
    }
}
