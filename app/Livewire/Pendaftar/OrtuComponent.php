<?php

namespace App\Livewire\Pendaftar;

use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\Ortu;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrtuComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    #[Computed()]
    public function calonPesertaDidik()
    {
        return CalonPesertaDidik::find(auth()->user()->calon_peserta_didik_id);
    }

    #[Computed()]
    public function ortu()
    {
        return Ortu::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first();
    }

    public function mount()
    {
        $this->form->fill(
            $this->ortu->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form->schema([
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
                            ignorable: fn () => $this->calonPesertaDidik(),
                        )
                        ->maxLength(16),
                    Forms\Components\TextInput::make('tahun_lahir_ayah')
                        ->label('Tahun Lahir')
                        ->maxLength(4),
                    Forms\Components\Select::make('pendidikan_ayah')
                        ->options(Pendidikan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('pekerjaan_ayah')
                        ->options(Pekerjaan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('penghasilan_ayah')
                        ->options(Penghasilan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('berkebutuhan_khusus_ayah')
                        ->options(BerkebutuhanKhusus::pluck('nama', 'id'))
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
                            ignorable: fn () => $this->calonPesertaDidik(),
                        )
                        ->maxLength(16),
                    Forms\Components\TextInput::make('tahun_lahir_ibu')
                        ->label('Tahun Lahir')
                        ->maxLength(4),
                    Forms\Components\Select::make('pendidikan_ibu')
                        ->options(Pendidikan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('pekerjaan_ibu')
                        ->options(Pekerjaan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('penghasilan_ibu')
                        ->options(Penghasilan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('berkebutuhan_khusus_ibu')
                        ->options(BerkebutuhanKhusus::pluck('nama', 'id'))
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
                            ignorable: fn () => $this->calonPesertaDidik(),
                        )
                        ->maxLength(16),
                    Forms\Components\TextInput::make('tahun_lahir_wali')
                        ->label('Tahun Lahir')
                        ->maxLength(4),
                    Forms\Components\Select::make('pendidikan_wali')
                        ->options(Pendidikan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('pekerjaan_wali')
                        ->options(Pekerjaan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('penghasilan_wali')
                        ->options(Penghasilan::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('berkebutuhan_khusus_wali')
                        ->options(BerkebutuhanKhusus::pluck('nama', 'id'))
                        ->preload()
                        ->searchable(),
                ])->columns(2),

        ])->statePath('data');
    }

    public function handleSubmit(): void
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();

            $this->ortu->update($data);

            Notification::make()->title('Data Wali Berhasil disimpan!')->success()->send();
            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.ortu-component');
    }
}
