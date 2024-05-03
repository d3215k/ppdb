<?php

namespace App\Filament\Resources;

use App\Events\TahunPelajaranAktifChanged;
use App\Filament\Clusters\ReferensiData;
use App\Filament\Resources\TahunPelajaranResource\Pages;
use App\Filament\Resources\TahunPelajaranResource\RelationManagers;
use App\Models\TahunPelajaran;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TahunPelajaranResource extends Resource
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $model = TahunPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ReferensiData::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendaftaran_count')
                    ->counts('pendaftaran')
                    ->label('Jumlah Pendaftar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('diterima_count')
                    ->counts('diterima')
                    ->label('Diterima')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('aktif')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                            TahunPelajaran::query()
                                ->whereNot('id', $record->id)
                                ->update([
                                    'aktif' => false
                                ]);

                            $setting = new SettingSekolah();
                            $setting->tahun_pelajaran_aktif = $record->id;
                            $setting->save();

                            TahunPelajaranAktifChanged::dispatch($record->id);
                        }
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
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
            // RelationManagers\KuotaJalurRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTahunPelajarans::route('/'),
            'create' => Pages\CreateTahunPelajaran::route('/create'),
            'edit' => Pages\EditTahunPelajaran::route('/{record}/edit'),
        ];
    }
}
