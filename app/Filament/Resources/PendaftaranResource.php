<?php

namespace App\Filament\Resources;

use App\Enums\StatusPendaftaran;
use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Models\AsalSekolah;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyPanitiaCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranResource extends Resource
{
    use EnsureOnlyPanitiaCanAccess;

    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'calonPesertaDidik',
                'calonPesertaDidik.asalSekolah',
                'jalur',
                'pilihanKesatu',
                'pilihanKedua',
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calon_peserta_didik_id')
                    ->relationship(
                        name: 'calonPesertaDidik',
                        titleAttribute: 'nama'
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('jalur_id')
                    ->relationship('jalur', 'nama')
                    ->required(),
                Forms\Components\Select::make('gelombang_id')
                    ->relationship('gelombang', 'nama')
                    ->required(),
                Forms\Components\Select::make('pilihan_kesatu')
                    ->options(KompetensiKeahlian::where('dipilih_kesatu', true)->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('pilihan_kedua')
                    ->options(KompetensiKeahlian::where('dipilih_kedua', true)->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('kompetensi_keahlian')
                    ->options(KompetensiKeahlian::pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\ToggleButtons::make('status')
                    ->options(StatusPendaftaran::class)
                    ->inline()
                    ->hiddenOn('create')
                    ->columnSpanFull()
                    ->disabled(fn (SettingSekolah $setting) => ! $setting->pelulusan),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('calonPesertaDidik.nama')
                    ->label('Nama / Asal Sekolah')
                    ->description(fn (Pendaftaran $record) => $record->calonPesertaDidik->asalSekolah?->nama)
                    ->sortable(),
                Tables\Columns\TextColumn::make('gelombang.nama')
                    ->label('Gelombang / Jalur')
                    ->description(fn (Pendaftaran $record) => $record->jalur->nama)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pilihanKesatu.kode')
                    ->label('Pilihan Kesatu dan Kedua')
                    ->description(fn (Pendaftaran $record) => $record->pilihanKedua->kode)
                    ->sortable(),
                Tables\Columns\TextColumn::make('diterima.kode')
                    ->label('Diterima')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gelombang_id')
                    ->label('Gelombang')
                    ->options(Gelombang::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('jalur_id')
                    ->label('Jalur')
                    ->options(Jalur::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('Asal Sekolah')
                    ->relationship('calonPesertaDidik.asalSekolah', 'nama')
                    ->searchable()
                    ->options(AsalSekolah::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('pilihan_kesatu')
                    ->options(KompetensiKeahlian::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('pilihan_kedua')
                    ->options(KompetensiKeahlian::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('kompetensi_keahlian')
                    ->label('Diterima')
                    ->options(KompetensiKeahlian::pluck('nama', 'id')),
                Tables\Filters\SelectFilter::make('status')
                    ->options(StatusPendaftaran::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('Cetak')
                ->url(fn (Pendaftaran $record) => route('pendaftar.cetak', $record->nomor))
                    ->icon('heroicon-m-printer')
                    ->openUrlInNewTab()
                    ->iconButton(),
                Tables\Actions\Action::make('Calon Peserta Didik')
                    ->url(fn (Pendaftaran $record) => route('filament.app.resources.calon-peserta-didiks.edit', $record->calonPesertaDidik))
                    ->icon('heroicon-m-user')
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Kelulusan')
                    // ->icon('heroicon-m-user')
                    ->action(function (Collection $records, array $data): void {
                        try {
                            foreach ($records as $record) {
                                $record->kompetensi_keahlian = $data['kompetensi_keahlian_id'];
                                $record->save();
                            }
                            Notification::make()->title('Kelulusan di set!')->success()->send();
                        } catch (\Throwable $th) {
                            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                            report($th->getMessage());
                        }

                    })
                    ->form([
                        Forms\Components\Select::make('kompetensi_keahlian_id')
                            ->label('Lulus Pada Kompetensi Keahlian')
                            ->options(KompetensiKeahlian::pluck('nama', 'id'))
                            ->searchable()
                            ->preload()
                        // Forms\Components\ToggleButtons::make('status')
                        //     ->options(StatusPendaftaran::class)
                        //     ->inline(),
                    ])
                    ->hidden(fn (SettingSekolah $setting) => ! $setting->pelulusan)
                    ->deselectRecordsAfterCompletion(),
            ])
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(3);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BuktiPersyaratanKhususRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }
}
