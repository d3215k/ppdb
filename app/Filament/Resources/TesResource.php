<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TesResource\Pages;
use App\Filament\Resources\TesResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Tes;
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

class TesResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = Tes::class;

    protected static ?string $modelLabel = 'Minat dan Bakat';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Tes';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Hasil Tes')
                    ->schema([
                        Forms\Components\TextInput::make('minat_bakat')
                            ->required()
                            ->minValue(10)
                            ->maxValue(100)
                            ->numeric(),
                        Forms\Components\TextInput::make('khusus')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.asalSekolah.nama')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextInputColumn::make('minat_bakat')
                    ->label('Minat dan Bakat')
                    ->rules(['nullable', 'numeric', 'max:100', 'min:10'])
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('khusus')
                    ->label('Tes Khusus')
                    ->rules(['nullable', 'numeric', 'max:100', 'min:10'])
                    ->sortable(),
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
                Tables\Actions\Action::make('Calon Peserta Didik')
                    ->url(fn (Tes $record) => route('filament.app.resources.calon-peserta-didiks.tes', $record->calonPesertaDidik))
                    ->icon('heroicon-m-user')
                    ->iconButton(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            // ->defaultSort('nama')
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(2)
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
            'index' => Pages\ListTes::route('/'),
            // 'create' => Pages\CreateTes::route('/create'),
            // 'edit' => Pages\EditTes::route('/{record}/edit'),
        ];
    }
}
