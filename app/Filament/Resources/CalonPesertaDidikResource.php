<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\CalonPesertaDidikResource\Pages;
use App\Filament\Resources\CalonPesertaDidikResource\RelationManagers;
use App\Models\CalonPesertaDidik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalonPesertaDidikResource extends Resource
{
    protected static ?string $model = CalonPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Referensi';

    public static function form(Form $form): Form
    {
        return $form
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_reg_akta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('berkebutuhanKhusus.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desa_kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lintang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bujur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempatTinggal.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modaTransportasi.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asalSekolah.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalonPesertaDidiks::route('/'),
            'create' => Pages\CreateCalonPesertaDidik::route('/create'),
            'edit' => Pages\EditCalonPesertaDidik::route('/{record}/edit'),
        ];
    }
}
