<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapitulasiResource\Pages;
use App\Filament\Resources\RekapitulasiResource\RelationManagers;
use App\Models\Rekapitulasi;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapitulasiResource extends Resource
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $model = Rekapitulasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Panitia';

    protected static ?int $navigationSort = 3;

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
                Tables\Columns\TextColumn::make('foo')
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRekapitulasis::route('/'),
            // 'create' => Pages\CreateRekapitulasi::route('/create'),
            // 'edit' => Pages\EditRekapitulasi::route('/{record}/edit'),
        ];
    }
}
