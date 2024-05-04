<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\ReferensiData;
use App\Filament\Resources\GelombangResource\Pages;
use App\Filament\Resources\GelombangResource\RelationManagers;
use App\Models\Gelombang;
use App\Models\TahunPelajaran;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GelombangResource extends Resource
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $model = Gelombang::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $cluster = ReferensiData::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationGroup = 'Periode';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('mulai')
                    ->required(),
                Forms\Components\DatePicker::make('sampai')
                    ->required(),
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
                Tables\Columns\TextColumn::make('mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sampai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jalur_count')
                    ->counts('jalur')
                    ->label('Jalur Dibuka'),
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
                Tables\Columns\ToggleColumn::make('aktif')
                    // ->afterStateUpdated(function ($record, $state) {
                    //     if ($state) {
                    //         Gelombang::query()
                    //             ->whereNot('id', $record->id)
                    //             ->where('tahun_pelajaran_id', $record->tahun_pelajaran_id)
                    //             ->update([
                    //                 'aktif' => false
                    //             ]);
                    //     }
                    // })
                    ,
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
            RelationManagers\JalurRelationManager::class,
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
