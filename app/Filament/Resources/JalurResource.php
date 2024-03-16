<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JalurResource\Pages;
use App\Filament\Resources\JalurResource\RelationManagers;
use App\Models\Jalur;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JalurResource extends Resource
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $model = Jalur::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 4;

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
                    ->sortable(),
                Tables\Columns\TextColumn::make('kuota_sum_kuotakuota')
                    ->sum('kuota', 'kuota.kuota')
                    ->label('Daya Tampung')
                    ->sortable(),
                Tables\Columns\ColumnGroup::make('Pendaftar', [
                    Tables\Columns\TextColumn::make('pendaftaran_count')
                        ->counts('pendaftaran')
                        ->label('Jumlah Pendaftar')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('diterima_count')
                        ->counts('diterima')
                        ->label('Diterima')
                        ->sortable(),
                ])->alignment(Alignment::Center),
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
