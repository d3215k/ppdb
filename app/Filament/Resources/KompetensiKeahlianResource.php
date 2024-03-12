<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KompetensiKeahlianResource\Pages;
use App\Filament\Resources\KompetensiKeahlianResource\RelationManagers;
use App\Models\KompetensiKeahlian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KompetensiKeahlianResource extends Resource
{
    protected static ?string $model = KompetensiKeahlian::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Sistem';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('dipilih_kesatu')
                    ->label('Dapat dipilih kesatu')
                    ->inline(false)
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('dipilih_kedua')
                    ->label('Dapat dipilih kedua')
                    ->inline(false)
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuota_sum_kuotakuota')
                    ->sum('kuota', 'kuota.kuota')
                    ->label('Kuota'),
                Tables\Columns\ToggleColumn::make('dipilih_kesatu'),
                Tables\Columns\ToggleColumn::make('dipilih_kedua'),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKompetensiKeahlians::route('/'),
            'create' => Pages\CreateKompetensiKeahlian::route('/create'),
            'edit' => Pages\EditKompetensiKeahlian::route('/{record}/edit'),
        ];
    }
}
