<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RaporResource\Pages;
use App\Filament\Resources\RaporResource\RelationManagers;
use App\Models\Rapor;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RaporResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = Rapor::class;

    protected static ?string $modelLabel = 'Rapor';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->modifyQueryUsing(
            //     fn ($query) => $query->withSummary()
            // )
            ->recordUrl(
                fn (Rapor $record): string => route('filament.app.resources.calon-peserta-didiks.rapor', $record),
            )
            ->columns([
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->description(fn (Rapor $record) => $record->calonPesertaDidik->asalSekolah->nama ?? '-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.pendaftaran.pilihanKesatu.kode')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('sum')
                    ->label('Total')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('avg')
                    ->label('Rata-rata')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pai')
                    ->label('PAI')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bindo')
                    ->label('B.Indo')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mtk')
                    ->label('MTK')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ipa')
                    ->label('IPA')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ips')
                    ->label('IPS')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bing')
                    ->label('B.Ing')
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sakit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('izin')
                    ->sortable(),
                Tables\Columns\TextColumn::make('alpa')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRapors::route('/'),
            'create' => Pages\CreateRapor::route('/create'),
            'edit' => Pages\EditRapor::route('/{record}/edit'),
        ];
    }
}
