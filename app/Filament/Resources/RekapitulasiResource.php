<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapitulasiResource\Pages;
use App\Filament\Resources\RekapitulasiResource\RelationManagers;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Rekapitulasi;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapitulasiResource extends Resource
{
    // use EnsureOnlyAdminCanAccess;

    protected static ?string $model = Rekapitulasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = 'Panitia';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return (auth()->user()->isAdmin || auth()->user()->isPanitia) && session('pelulusan', true);
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

    private static function getColumns()
    {
        $columns = [];
        $jalur = Jalur::all();
        $nama = $jalur->pluck('nama')->toArray();

        foreach ($jalur as $i => $item) {
            $columns[] = Tables\Columns\ColumnGroup::make($nama[$item->id - 1] , [
                Tables\Columns\TextColumn::make($item->id.'_kuota')
                    ->label('Kuota'),
                Tables\Columns\TextColumn::make($item->id.'_pendaftar_1_l')
                    ->label('1 (L)'),
                Tables\Columns\TextColumn::make($item->id.'_pendaftar_1_p')
                    ->label('1 (P)'),
                Tables\Columns\TextColumn::make($item->id.'_pendaftar_2_l')
                    ->label('2 (L)'),
                Tables\Columns\TextColumn::make($item->id.'_pendaftar_2_p')
                    ->label('2 (P)'),
                Tables\Columns\TextColumn::make($item->id.'_diterima_l')
                    ->label('Diterima (L)'),
                Tables\Columns\TextColumn::make($item->id.'_diterima_p')
                    ->label('Diterima (P)'),
            ])->alignCenter();
        }

        return $columns;
    }

    public static function table(Table $table): Table
    {
        $columns = self::getColumns();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('kuota'),
                Tables\Columns\TextColumn::make('pendaftar_1')
                    ->label('Pendaftar Pilihan 1'),
                Tables\Columns\TextColumn::make('pendaftar_2')
                    ->label('Pendaftar Pilihan 2'),
                Tables\Columns\TextColumn::make('diterima'),
                ...$columns
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
            ->paginated(false)
            ->striped();
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
