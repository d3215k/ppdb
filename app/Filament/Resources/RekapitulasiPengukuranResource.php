<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapitulasiPengukuranResource\Pages;
use App\Filament\Resources\RekapitulasiPengukuranResource\RelationManagers;
use App\Models\RekapitulasiPengukuran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapitulasiPengukuranResource extends Resource
{
    protected static ?string $model = RekapitulasiPengukuran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Ukuran Baju';

    protected static ?string $navigationGroup = 'Panitia';

    protected static ?string $navigationParentItem = 'Rekapitulasi';

    public static function shouldRegisterNavigation(): bool
    {
        return session('pelulusan', false);
    }

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
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('l'),
                Tables\Columns\TextColumn::make('p'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated(false);
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
            'index' => Pages\ListRekapitulasiPengukurans::route('/'),
        ];
    }
}
