<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\BacaTulisQuran;
use App\Models\Tes;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class HasilTesCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.hasil-tes-calon-peserta-didik';

    protected static ?string $title = 'Hasil Tes';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    public ?array $data = [];

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

        $this->form->fill([
            'kelancaran' => $this->getRecord()->btq->kelancaran,
            'kefasihan' => $this->getRecord()->btq->kefasihan,
            'tajwid' => $this->getRecord()->btq->tajwid,
            'keterangan' => $this->getRecord()->btq->keterangan,
            'minat_bakat' => $this->getRecord()->tes->minat_bakat,
            'khusus' => $this->getRecord()->tes->khusus,
        ]);
    }

    public function form(Form $form): Form
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
                Forms\Components\Fieldset::make('Hasil Tes Minat dan Bakat')
                    ->schema([
                        Forms\Components\TextInput::make('minat_bakat')
                            ->minValue(10)
                            ->maxValue(100)
                            ->numeric(),
                        Forms\Components\TextInput::make('khusus')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100),
                    ])
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function handleSubmit(): void
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $data = $this->form->getState();

            BacaTulisQuran::updateOrCreate(
                [
                    'calon_peserta_didik_id' => $this->record->id
                ],
                [
                    'kelancaran' => $data['kelancaran'],
                    'kefasihan' => $data['kefasihan'],
                    'tajwid' => $data['tajwid'],
                    'keterangan' => $data['keterangan'],
                ]
            );

            Tes::updateOrCreate(
                [
                    'calon_peserta_didik_id' => $this->record->id
                ],
                [
                    'minat_bakat' => $data['minat_bakat'],
                    'khusus' => $data['khusus'],
                ]
            );

            Notification::make()->title('Data Hasil Tes Berhasil disimpan!')->success()->send();
            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }
}
