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
use Illuminate\Contracts\Support\Htmlable;
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

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->asalSekolah->nama ?? '-';
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
                    ->label('Ijazah/Surat Keterangan Lulus/Kartu Peserta Ujian Sekolah')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),
                Forms\Components\FileUpload::make('dokumen_kelahiran')
                    // ->required()
                    ->label('Akta Kelahiran / KIA')
                    ->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),
                Forms\Components\FileUpload::make('kartu_keluarga')
                    // ->required()
                    ->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),
                Forms\Components\FileUpload::make('ktp_ortu')
                    // ->required()
                    ->nullable()
                    ->label('KTP Orang Tua')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),

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
