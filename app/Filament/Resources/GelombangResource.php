<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GelombangResource\Pages;
use App\Filament\Resources\GelombangResource\RelationManagers;
use App\Models\Gelombang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GelombangResource extends Resource
{
    protected static ?string $model = Gelombang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun_pelajaran_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('mulai')
                    ->required(),
                Forms\Components\DatePicker::make('sampai')
                    ->required(),
                Forms\Components\TextInput::make('link_wa_group')
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_pelajaran_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sampai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('link_wa_group')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListGelombangs::route('/'),
            'create' => Pages\CreateGelombang::route('/create'),
            'edit' => Pages\EditGelombang::route('/{record}/edit'),
        ];
    }
}
