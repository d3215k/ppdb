<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\BerkebutuhanKhusus;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class OrtuCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.ortu-calon-peserta-didik';

    protected static ?string $title = 'Orang Tua';

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
            $this->getRecord()->ortu->toArray(),
        );
    }

    #[Computed()]
    public function pendidikan()
    {
        return Pendidikan::pluck('nama', 'id');
    }

    #[Computed()]
    public function pekerjaan()
    {
        return Pekerjaan::pluck('nama', 'id');
    }

    #[Computed()]
    public function penghasilan()
    {
        return Penghasilan::pluck('nama', 'id');
    }

    #[Computed()]
    public function berkebutuhanKhusus()
    {
        return BerkebutuhanKhusus::pluck('nama', 'id');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ayah')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_ayah')
                            ->label('NIK')
                            ->unique(
                                table: 'calon_peserta_didik',
                                column: 'nik',
                                ignorable: fn () => $this->getRecord(),
                            )
                            ->maxLength(16),
                        Forms\Components\TextInput::make('tahun_lahir_ayah')
                            ->label('Tahun Lahir')
                            ->maxLength(4),
                        Forms\Components\Select::make('pendidikan_ayah')
                            ->options($this->pendidikan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('pekerjaan_ayah')
                            ->options($this->pekerjaan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('penghasilan_ayah')
                            ->options($this->penghasilan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('berkebutuhan_khusus_ayah')
                            ->options($this->berkebutuhanKhusus)
                            ->preload()
                            ->searchable(),
                    ])->columns(2),
                Forms\Components\Section::make('Ibu')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ibu')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_ibu')
                            ->label('NIK')
                            ->unique(
                                table: 'calon_peserta_didik',
                                column: 'nik',
                                ignorable: fn () => $this->getRecord(),
                            )
                            ->maxLength(16),
                        Forms\Components\TextInput::make('tahun_lahir_ibu')
                            ->label('Tahun Lahir')
                            ->maxLength(4),
                        Forms\Components\Select::make('pendidikan_ibu')
                            ->options($this->pendidikan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('pekerjaan_ibu')
                            ->options($this->pekerjaan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('penghasilan_ibu')
                            ->options($this->penghasilan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('berkebutuhan_khusus_ibu')
                            ->options($this->berkebutuhanKhusus)
                            ->preload()
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('Wali')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('nama_wali')
                            ->label('Nama Lengkap')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_wali')
                            ->label('NIK')
                            ->unique(
                                table: 'calon_peserta_didik',
                                column: 'nik',
                                ignorable: fn () => $this->getRecord(),
                            )
                            ->maxLength(16),
                        Forms\Components\TextInput::make('tahun_lahir_wali')
                            ->label('Tahun Lahir')
                            ->maxLength(4),
                        Forms\Components\Select::make('pendidikan_wali')
                            ->options($this->pendidikan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('pekerjaan_wali')
                            ->options($this->pekerjaan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('penghasilan_wali')
                            ->options($this->penghasilan)
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('berkebutuhan_khusus_wali')
                            ->options($this->berkebutuhanKhusus)
                            ->preload()
                            ->searchable(),
                    ])->columns(2),

            ])->statePath('data');
    }

    public function handleSubmit(): void
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $data = $this->form->getState();

            $this->getRecord()->ortu->update($data);

            Notification::make()->title('Data Wali Berhasil disimpan!')->success()->send();
            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

}
