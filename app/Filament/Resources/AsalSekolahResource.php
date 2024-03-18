<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsalSekolahResource\Pages;
use App\Filament\Resources\AsalSekolahResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsalSekolahResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = AsalSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Panitia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npsn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('calon_peserta_didik_count')
                    ->label('Data Calon Peserta Didik')
                    ->counts('calonPesertaDidik'),
                Tables\Columns\ColumnGroup::make('Pendaftaran', [
                    Tables\Columns\TextColumn::make('pendaftaran_count')
                        ->counts('pendaftaran')
                        ->label('Pendaftar')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('diterima_count')
                        ->counts('diterima')
                        ->label('Diterima')
                        ->sortable(),
                ])->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->striped();
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
            'index' => Pages\ListAsalSekolahs::route('/'),
            'create' => Pages\CreateAsalSekolah::route('/create'),
            'edit' => Pages\EditAsalSekolah::route('/{record}/edit'),
        ];
    }
}
