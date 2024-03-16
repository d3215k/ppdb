<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;

class PersyaratanUmumCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.persyaratan-umum-calon-peserta-didik';

    protected static ?string $title = 'Persyaratan Umum';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill(
            $this->getRecord()->persyaratanUmum->toArray(),
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('dokumen_kelulusan')
                    // ->required()
                    ->nullable()
                    ->downloadable(),
                Forms\Components\FileUpload::make('dokumen_kelahiran')
                    // ->required()
                    ->nullable()
                    ->downloadable(),
                Forms\Components\FileUpload::make('kartu_keluarga')
                    // ->required()
                    ->nullable()
                    ->downloadable(),
                Forms\Components\FileUpload::make('ktp_ortu')
                    // ->required()
                    ->nullable()
                    ->downloadable(),

            ])
            ->columns(2)
            ->statePath('data');
    }

    public function handleSubmit(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $data = $this->form->getState();

            $this->getRecord()->persyaratanUmum->update($data);

            Notification::make()->title('Berkas Berhasil disimpan!')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }
}
