<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapitulasiNomorSepatuResource\Pages;
use App\Filament\Resources\RekapitulasiNomorSepatuResource\RelationManagers;
use App\Models\RekapitulasiNomorSepatu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapitulasiNomorSepatuResource extends Resource
{
    protected static ?string $model = RekapitulasiNomorSepatu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Ukuran Sepatu';

    protected static ?string $navigationGroup = 'Panitia';

    protected static ?string $navigationParentItem = 'Rekapitulasi';

    public static function shouldRegisterNavigation(): bool
    {
        return (auth()->user()->isAdmin || auth()->user()->isPanitia) && session('pelulusan', false);
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin || auth()->user()->isPanitia;
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
                Tables\Columns\TextColumn::make('nama')
                    ->label('Ukuran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('l')
                    ->label('Laki-laki')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('p')
                    ->label('Perempuan')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListRekapitulasiNomorSepatus::route('/'),
            // 'create' => Pages\CreateRekapitulasiNomorSepatu::route('/create'),
            // 'edit' => Pages\EditRekapitulasiNomorSepatu::route('/{record}/edit'),
        ];
    }
}
