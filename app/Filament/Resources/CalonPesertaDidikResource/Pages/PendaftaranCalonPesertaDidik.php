<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Enums\StatusPendaftaran;
use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\Gelombang;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use App\Models\TahunPelajaran;
use App\Support\GenerateNumber;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranCalonPesertaDidik extends ManageRelatedRecords
{
    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $relationship = 'pendaftaran';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    public static function getNavigationLabel(): string
    {
        return 'Pendaftaran';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\ToggleButtons::make('status')
                    ->options(StatusPendaftaran::class)
                    ->inline()
                    ->hiddenOn('create')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nomor')
            ->columns([
                Tables\Columns\TextColumn::make('nomor'),
                Tables\Columns\TextColumn::make('jalur.nama'),
                Tables\Columns\TextColumn::make('gelombang.nama'),
                Tables\Columns\TextColumn::make('pilihanKesatu.nama'),
                Tables\Columns\TextColumn::make('pilihanKedua.nama'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $tahun = TahunPelajaran::whereAktif(true)->first();
                        $gelombang = Gelombang::find($data['gelombang_id']);
                        $data['tahun_pelajaran_id'] = $tahun->id;
                        $data['nomor'] = GenerateNumber::pendaftaran($tahun, $gelombang);

                        return $data;
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('Cetak')
                    ->url(fn (Pendaftaran $record) => route('pendaftar.cetak', $record->nomor))
                    ->icon('heroicon-m-printer')
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DissociateBulkAction::make(),
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated(false);
    }
}
