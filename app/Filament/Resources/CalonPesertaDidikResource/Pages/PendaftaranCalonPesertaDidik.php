<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Enums\StatusPendaftaran;
use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\Gelombang;
use App\Models\KompetensiKeahlian;
use App\Models\Pendaftaran;
use App\Models\TahunPelajaran;
use App\Settings\SettingSekolah;
use App\Support\GenerateNumber;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class PendaftaranCalonPesertaDidik extends ManageRelatedRecords
{
    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $relationship = 'pendaftaran';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->asalSekolah->nama ?? '-';
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
                    ->label('Pilihan Kompetensi Keahlian Pertama')
                    ->options(fn (): Collection => KompetensiKeahlian::query()
                        ->where('dipilih_kesatu', true)
                        ->pluck('nama', 'id')
                    )
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        if ($state === $get('pilihan_kedua')) {
                            $set('pilihan_kedua', null);
                        }
                    }),
                Forms\Components\Select::make('pilihan_kedua')
                    ->label('Pilihan Kompetensi Keahlian Kedua')
                    ->options(fn (Get $get): Collection => KompetensiKeahlian::query()
                        ->where('dipilih_kedua', true)
                        ->whereNot('id', $get('pilihan_kesatu'))
                        ->pluck('nama', 'id')
                    )
                    ->reactive()
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->options(StatusPendaftaran::class)
                    ->inline()
                    ->hiddenOn('create')
                    ->disabled(fn (SettingSekolah $setting) => ! $setting->pelulusan)
                    ->columnSpanFull()
                    ->reactive(),
                Forms\Components\Select::make('kompetensi_keahlian')
                    ->options(KompetensiKeahlian::pluck('nama', 'id'))
                    ->label('Diterima pada Kompetensi Keahlian')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->hidden(function (Get $get): bool {
                        return $get('status') != StatusPendaftaran::LULUS->value;
                    }),
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
                Tables\Columns\TextColumn::make('pilihanKesatu.kode'),
                Tables\Columns\TextColumn::make('pilihanKedua.kode'),
                Tables\Columns\TextColumn::make('diterima.kode')
                    ->label('Diterima')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Daftarkan')
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
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if ((int) $data['status'] !== StatusPendaftaran::LULUS->value) {
                            $data['kompetensi_keahlian'] = null;
                        }

                        return $data;
                    }),
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
