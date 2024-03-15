<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JarakRumah;
use App\Enums\UkuranBaju;
use App\Models\CalonPesertaDidik;
use App\Models\Periodik;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
            Periodik::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first()->toArray()
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
                    ->required()
                    ->numeric(),
                Forms\Components\Radio::make('jarak_rumah')
                    ->options(JarakRumah::class)
                    ->required()
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
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('tindik')
                    // ->required()
                    ->boolean()
                    ->grouped()
                    ->inline(),
                Forms\Components\ToggleButtons::make('cat_rambut')
                    // ->required()
                    ->boolean()
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
