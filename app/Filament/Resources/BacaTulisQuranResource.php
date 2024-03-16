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
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            // ->modifyQueryUsing(
            //     fn($query) => $query->withPilihanPertama()
            // )
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
