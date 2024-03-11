<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapitulasiResource\Pages;
use App\Filament\Resources\RekapitulasiResource\RelationManagers;
use App\Models\Rekapitulasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapitulasiResource extends Resource
{
    protected static ?string $model = Rekapitulasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRekapitulasis::route('/'),
            // 'create' => Pages\CreateRekapitulasi::route('/create'),
            // 'edit' => Pages\EditRekapitulasi::route('/{record}/edit'),
        ];
    }
}
