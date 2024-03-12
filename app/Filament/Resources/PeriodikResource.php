<?php

namespace App\Filament\Resources;

use App\Enums\UkuranBaju;
use App\Filament\Resources\PeriodikResource\Pages;
use App\Filament\Resources\PeriodikResource\RelationManagers;
use App\Models\CalonPesertaDidik;
use App\Models\Periodik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodikResource extends Resource
{
    protected static ?string $model = CalonPesertaDidik::class;

    protected static ?string $modelLabel = 'Cek Fisik';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Tes';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
                        ->whereHas('pendaftaran');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Calon Peserta Didik')
                    ->schema([
                        Forms\Components\Placeholder::make('nama')
                            ->content(fn (CalonPesertaDidik $record): string => $record->nama),
                        Forms\Components\Placeholder::make('Asal Sekolah')
                            ->content(fn (CalonPesertaDidik $record): string => $record->asalSekolah->nama ?? '-'),
                        Forms\Components\Placeholder::make('Pilihan Kesatu')
                            ->content(fn (CalonPesertaDidik $record): string => $record->pendaftaran->pilihanKesatu->nama ?? '-'),
                    ]),
                Forms\Components\Fieldset::make('Hasil Cek Fisik')
                    ->relationship('periodik')
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
                        Forms\Components\Select::make('ukuran_baju')
                            ->nullable()
                            ->options(UkuranBaju::class),
                        Forms\Components\ToggleButtons::make('tato')
                            ->required()
                            ->boolean()
                            ->inline(),
                        Forms\Components\ToggleButtons::make('tindik')
                            ->required()
                            ->boolean()
                            ->inline(),
                        Forms\Components\ToggleButtons::make('cat_rambut')
                            ->required()
                            ->boolean()
                            ->inline(),

                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('periodik.tinggi')
                    ->label('Tinggi (cm)')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('periodik.berat')
                    ->label('Berat (Kg)')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('periodik.lingkar_kepala')
                    ->label('Lingkar Kepala')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('periodik.no_sepatu')
                    ->label('Nomor Sepatu')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('periodik.ukuran_baju')
                    ->label('Ukuran Baju')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('periodik.tato')
                    ->label('Tato')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
                Tables\Columns\IconColumn::make('periodik.tindik')
                    ->label('Tindik')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
                Tables\Columns\IconColumn::make('periodik.cat_rambut')
                    ->label('Cat Rambut')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListPeriodiks::route('/'),
            'create' => Pages\CreatePeriodik::route('/create'),
            'edit' => Pages\EditPeriodik::route('/{record}/edit'),
        ];
    }
}
