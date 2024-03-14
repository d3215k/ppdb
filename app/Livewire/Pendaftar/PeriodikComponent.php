<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Enums\UkuranBaju;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\ModaTransportasi;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\Periodik;
use App\Models\TempatTinggal;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PeriodikComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $periodik = [];

    #[Computed()]
    public function calonPesertaDidik()
    {
        return CalonPesertaDidik::find(auth()->user()->calon_peserta_didik_id);
    }

    public function mount()
    {
        $this->form->fill(
            Periodik::find(auth()->user()->calon_peserta_didik_id)?->toArray()
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
                Forms\Components\TextInput::make('no_sepatu')
                    ->nullable()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('ukuran_baju')
                    ->inline()
                    ->nullable()
                    ->options(UkuranBaju::class),
                Forms\Components\ToggleButtons::make('tato')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('tindik')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('cat_rambut')
                    ->required()
                    ->boolean()
                    ->grouped()
                    ->inline(),
            ])
            ->columns(2)
            ->statePath('periodik');
        }

    public function handleSubmit(): void
    {
        try {
            DB::beginTransaction();

            $periodik = $this->form->getState();

            Periodik::updateOrCreate(
                [
                    'calon_peserta_didik_id' => auth()->user()->calon_peserta_didik_id
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

    public function render(): View
    {
        return view('livewire.pendaftar.periodik-component');
    }
}
