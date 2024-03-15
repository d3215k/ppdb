<?php

namespace App\Livewire\Pendaftar;

use App\Models\Rapor;
use App\Traits\WithPlaceholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RaporComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use WithPlaceholder;

    public ?array $data = [];

    #[Computed()]
    public function rapor()
    {
        return Rapor::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)
            ->with('calonPesertaDidik:id,locked')
            ->first();
    }

    public function mount()
    {
        $this->form->fill(
            $this->rapor->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->disabled(fn() => $this->rapor->calonPesertaDidik->locked)
            ->schema([
                Forms\Components\Fieldset::make('pai')
                    ->label('Pendidikan Agama Islam')
                    ->schema([
                        Forms\Components\TextInput::make('pai_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('pai_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('pai_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('pai_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('pai_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('bindo')
                    ->label('Bahasa Indonesia')
                    ->schema([
                        Forms\Components\TextInput::make('bindo_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bindo_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bindo_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bindo_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bindo_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('mtk')
                    ->label('Matematika')
                    ->schema([
                        Forms\Components\TextInput::make('mtk_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('mtk_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('mtk_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('mtk_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('mtk_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('ipa')
                    ->label('Ilmu Pengetahuan Alam')
                    ->schema([
                        Forms\Components\TextInput::make('ipa_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ipa_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ipa_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ipa_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ipa_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('ips')
                    ->label('Ilmu Pengetahuan Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('ips_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ips_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ips_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ips_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('ips_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('bing')
                    ->label('Bahasa Inggris')
                    ->schema([
                        Forms\Components\TextInput::make('bing_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bing_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bing_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bing_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('bing_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(5),
                Forms\Components\FileUpload::make('halaman_identitas')
                    ->downloadable(),
                Forms\Components\FileUpload::make('halaman_nilai_semester')
                    ->downloadable(),

                Forms\Components\Fieldset::make('Jumlah Ketidakhadiran')
                    ->schema([
                        Forms\Components\TextInput::make('sakit')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('izin')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                        Forms\Components\TextInput::make('alpa')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(0),
                    ])
                    ->columns(3),
                Forms\Components\FileUpload::make('halaman_kehadiran')
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

            $this->rapor->update($data);

            Notification::make()->title('Data Rapor berhasil disimpan!')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.rapor-component');
    }
}
