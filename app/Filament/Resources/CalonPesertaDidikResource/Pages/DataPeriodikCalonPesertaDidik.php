<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Enums\JarakRumah;
use App\Enums\UkuranBaju;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\Periodik;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class DataPeriodikCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.data-periodik-calon-peserta-didik';

    protected static ?string $title = 'Data Periodik';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $periodik = [];

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->asalSekolah->nama ?? '-';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill(
            $this->getRecord()->periodik->toArray(),
        );
    }

    public function form(Form $form): Form
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
                Forms\Components\TextInput::make('jumlah_saudara_kandung')
                    ->label('Jumlah Saudara Kandung')
                    // ->required()
                    ->numeric(),
                Forms\Components\Radio::make('jarak_rumah')
                    ->options(JarakRumah::class)
                    // ->required()
                    ->reactive(),
                Forms\Components\TextInput::make('jarak_km')
                    ->label('Sebutkan')
                    ->suffix('kilometer')
                    ->default(0)
                    ->numeric()
                    ->hidden(fn (Get $get): bool => ! $get('jarak_rumah')),
                Forms\Components\TextInput::make('waktu_tempuh')
                    ->label('Waktu tempuh ke sekolah')
                    ->default(0)
                    ->suffix('menit')
                    ->numeric(),
                Forms\Components\TextInput::make('no_sepatu')
                    ->nullable()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('ukuran_baju')
                    ->inline()
                    ->nullable()
                    ->options(UkuranBaju::class),
                Forms\Components\ToggleButtons::make('tato')
                    // ->required()
                    ->boolean()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('tindik')
                    // ->required()
                    ->boolean()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('cat_rambut')
                    // ->required()
                    ->boolean()
                    ->colors([
                        true => 'danger',
                        false => 'success',
                    ])
                    ->grouped()
                    ->inline(),
            ])
            ->columns(2)
            ->statePath('periodik');
    }

    public function handleSubmit(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $periodik = $this->form->getState();

            Periodik::updateOrCreate(
                [
                    'calon_peserta_didik_id' => $this->record->id
                ],
                $periodik
            );

            Notification::make()->title('Data Periodik Berhasil disimpan!')->success()->send();
            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }
}
