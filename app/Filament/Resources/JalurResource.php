<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JalurResource\Pages;
use App\Filament\Resources\JalurResource\RelationManagers;
use App\Models\Jalur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JalurResource extends Resource
{
    protected static ?string $model = Jalur::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Sistem';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->inline(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuota_sum_kuotakuota')
                    ->sum('kuota', 'kuota.kuota')
                    ->label('Kuota'),
                Tables\Columns\TextColumn::make('gelombang_count')
                    ->counts('gelombang')
                    ->label('Gelombang Dibuka'),
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
            ->paginated(false);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KuotaRelationManager::class,
            RelationManagers\PersyaratanKhususRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJalurs::route('/'),
            'create' => Pages\CreateJalur::route('/create'),
            'edit' => Pages\EditJalur::route('/{record}/edit'),
        ];
    }
}
