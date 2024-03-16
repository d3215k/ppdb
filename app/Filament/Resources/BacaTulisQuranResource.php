<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BacaTulisQuranResource\Pages;
use App\Filament\Resources\BacaTulisQuranResource\RelationManagers;
use App\Models\BacaTulisQuran;
use App\Models\CalonPesertaDidik;
use App\Traits\EnsureOnlyPengujiCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withPendaftaranAktif();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Fieldset::make('Calon Peserta Didik')
                        ->schema([
                            Forms\Components\Placeholder::make('nama')
                                ->content(fn (BacaTulisQuran $record): string => $record->calonPesertaDidik->nama),
                            Forms\Components\Placeholder::make('Asal Sekolah')
                                ->content(fn (BacaTulisQuran $record): string => $record->calonPesertaDidik->asalSekolah->nama ?? '-'),
                            Forms\Components\Placeholder::make('Pilihan Kesatu')
                                ->content(fn (BacaTulisQuran $record): string => $record->calonPesertaDidik->pendaftaranAktif ?? '-'),
                        ]),
                        Forms\Components\Placeholder::make('Foto')
                            ->hiddenLabel()
                            ->content(fn (BacaTulisQuran $record) => $record->calonPesertaDidik->foto ? new HtmlString('<img width="200px" src="'.asset('storage/'. $record->calonPesertaDidik->foto).'"/>') : '-'),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Hasil Tes BTQ')
                    ->schema([
                        Forms\Components\TextInput::make('kelancaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('kefasihan')
                            ->numeric(),
                        Forms\Components\TextInput::make('tajwid')
                            ->numeric(),
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
                Tables\Columns\TextColumn::make('pendaftaranAktif')
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
