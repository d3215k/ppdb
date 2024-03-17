<?php

namespace App\Filament\Resources;

use App\Enums\UkuranBaju;
use App\Filament\Resources\PeriodikResource\Pages;
use App\Filament\Resources\PeriodikResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Periodik;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodikResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = Periodik::class;

    protected static ?string $modelLabel = 'Cek Fisik';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Tes';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tinggi')
                    ->nullable()
                    ->suffix('cm')
                    ->numeric(),
                Forms\Components\TextInput::make('berat')
                    ->nullable()
                    ->suffix('Kg')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_kepala')
                    ->nullable()
                    ->numeric(),
                Forms\Components\TextInput::make('no_sepatu')
                    ->nullable()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('ukuran_baju')
                    ->nullable()
                    ->inline()
                    ->options(UkuranBaju::class),
                Forms\Components\ToggleButtons::make('tato')
                    ->required()
                    ->boolean()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('tindik')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->inline(),
                Forms\Components\ToggleButtons::make('cat_rambut')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->description(fn (Periodik $record) => $record->calonPesertaDidik->asalSekolah->nama ?? '-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('tinggi')
                    ->label('Tinggi (cm)')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('berat')
                    ->label('Berat (Kg)')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('lingkar_kepala')
                    ->label('Lingkar Kepala')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('no_sepatu')
                    ->label('Nomor Sepatu')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ukuran_baju')
                    ->label('Ukuran Baju')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('tato')
                    ->label('Tato')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
                Tables\Columns\IconColumn::make('tindik')
                    ->label('Tindik')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
                Tables\Columns\IconColumn::make('cat_rambut')
                    ->label('Cat Rambut')
                    ->boolean()
                    ->default(false)
                    ->toggleable(
                        condition:true,
                        isToggledHiddenByDefault:true
                    ),
            ])
            ->filters([
                SelectFilter::make('Gelombang')
                    ->options(
                        fn() => Gelombang::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'calonPesertaDidik',
                                fn (Builder $query) => $query->whereHas(
                                    'pendaftaran',
                                    fn (Builder $query) => $query->where('gelombang_id', '=', (int) $data['value'])
                                )
                            );
                        }
                    }),
                SelectFilter::make('Jalur')
                    ->options(
                        fn() => Jalur::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'calonPesertaDidik',
                                fn (Builder $query) => $query->whereHas(
                                    'pendaftaran',
                                    fn (Builder $query) => $query->where('jalur_id', '=', (int) $data['value'])
                                )
                            );
                        }
                    }),
                SelectFilter::make('Asal Sekolah')
                    ->options(
                        fn() => AsalSekolah::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'calonPesertaDidik',
                                fn (Builder $query) => $query->where('asal_sekolah_id', '=', (int) $data['value'])
                            );
                        }
                    }),
                SelectFilter::make('Pilihan Kesatu')
                    ->options(
                        fn() => KompetensiKeahlian::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'calonPesertaDidik',
                                fn (Builder $query) => $query->whereHas(
                                    'pendaftaran',
                                    fn (Builder $query) => $query->where('pilihan_kesatu', '=', (int) $data['value'])
                                )
                            );
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(2);
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
            'index' => Pages\ListPeriodiks::route('/'),
            'create' => Pages\CreatePeriodik::route('/create'),
            'edit' => Pages\EditPeriodik::route('/{record}/edit'),
        ];
    }
}
