<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\BacaTulisQuranResource\Pages;
use App\Filament\Resources\BacaTulisQuranResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\BacaTulisQuran;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\User;
use App\Traits\EnsureOnlyPengujiCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class BacaTulisQuranResource extends Resource
{
    use EnsureOnlyPengujiCanAccess;

    protected static ?string $model = BacaTulisQuran::class;

    protected static ?string $modelLabel = 'Baca Tulis Qur\'an';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Tes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Hasil Tes BTQ')
                    ->schema([
                        Forms\Components\TextInput::make('kelancaran')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('kefasihan')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('tajwid')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100),
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->description(fn (BacaTulisQuran $record) => $record->calonPesertaDidik->asalSekolah->nama ?? '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('penguji.name')
                    ->label('Penguji')
                    ->default('-'),
                Tables\Columns\TextColumn::make('kelancaran')
                    ->label('Kelancaran')
                    ->numeric()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('kefasihan')
                    ->label('Kefasihan')
                    ->numeric()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('tajwid')
                    ->label('Tajwid')
                    ->numeric()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->default('-'),
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
                SelectFilter::make('Penguji')
                    ->options(
                        fn() => User::where('type', UserType::PENGUJI)->pluck('name', 'id')->toArray(),
                    )
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->where('user_id', '=', (int) $data['value']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('Calon Peserta Didik')
                    ->url(fn (BacaTulisQuran $record) => route('filament.app.resources.calon-peserta-didiks.tes', $record->calonPesertaDidik))
                    ->icon('heroicon-m-user')
                    ->iconButton()
                    ->hidden(fn (User $user) => $user->isPenguji ),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListBacaTulisQurans::route('/'),
            // 'create' => Pages\CreateBacaTulisQuran::route('/create'),
            'edit' => Pages\EditBacaTulisQuran::route('/{record}/edit'),
        ];
    }
}
