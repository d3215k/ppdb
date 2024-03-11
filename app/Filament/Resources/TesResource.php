<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TesResource\Pages;
use App\Filament\Resources\TesResource\RelationManagers;
use App\Models\CalonPesertaDidik;
use App\Models\Tes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TesResource extends Resource
{
    protected static ?string $model = CalonPesertaDidik::class;

    protected static ?string $modelLabel = 'Minat dan Bakat';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

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
                Forms\Components\Fieldset::make('Hasil Tes')
                    ->relationship('tes')
                    ->schema([
                        Forms\Components\TextInput::make('minat_bakat')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('khusus')
                            ->numeric(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asalSekolah.nama')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('tes.minat_bakat')
                    ->label('Minat dan Bakat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tes.khusus')
                    ->label('Tes Khusus')
                    ->sortable(),
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
            'index' => Pages\ListTes::route('/'),
            // 'create' => Pages\CreateTes::route('/create'),
            // 'edit' => Pages\EditTes::route('/{record}/edit'),
        ];
    }
}
