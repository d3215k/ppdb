<?php

namespace App\Livewire\Pendaftar;

use App\Enums\JenisKelamin;
use App\Models\Agama;
use App\Models\AsalSekolah;
use App\Models\BerkebutuhanKhusus;
use App\Models\CalonPesertaDidik;
use App\Models\Gelombang;
use App\Models\Jalur;
use App\Models\KompetensiKeahlian;
use App\Models\ModaTransportasi;
use App\Models\Pendaftaran;
use App\Models\Rapor;
use App\Models\TahunPelajaran;
use App\Models\TempatTinggal;
use App\Support\GenerateNumber;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RaporComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    #[Computed()]
    public function rapor()
    {
        return Rapor::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->first();
    }

    public function mount()
    {
        $this->form->fill(
            $this->rapor()?->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
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
        try {
            DB::beginTransaction();

            $data = $this->form->getState();

            Rapor::updateOrCreate(
                [
                    'calon_peserta_didik_id' => auth()->user()->calon_peserta_didik_id,
                ],
                $data,
            );

            Notification::make()->title('berhasil')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title($th->getMessage())->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pendaftar.rapor-component');
    }
}
