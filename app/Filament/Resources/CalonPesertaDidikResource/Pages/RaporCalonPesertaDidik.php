<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\Rapor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class RaporCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.rapor-calon-peserta-didik';

    protected static ?string $title = 'Rapor';

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
            $this->getRecord()->rapor->toArray(),
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('pai')
                    ->label('Pendidikan Agama dan Budi Pekerti')
                    ->schema([
                        Forms\Components\TextInput::make('pai_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('pai_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('pai_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('pai_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('pai_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('bindo')
                    ->label('Bahasa Indonesia')
                    ->schema([
                        Forms\Components\TextInput::make('bindo_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bindo_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bindo_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bindo_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bindo_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('mtk')
                    ->label('Matematika')
                    ->schema([
                        Forms\Components\TextInput::make('mtk_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('mtk_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('mtk_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('mtk_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('mtk_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('ipa')
                    ->label('Ilmu Pengetahuan Alam')
                    ->schema([
                        Forms\Components\TextInput::make('ipa_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ipa_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ipa_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ipa_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ipa_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('ips')
                    ->label('Ilmu Pengetahuan Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('ips_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ips_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ips_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ips_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('ips_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\Fieldset::make('bing')
                    ->label('Bahasa Inggris')
                    ->schema([
                        Forms\Components\TextInput::make('bing_1')
                            ->label('Sem. I')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bing_2')
                            ->label('Sem. II')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bing_3')
                            ->label('Sem. III')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bing_4')
                            ->label('Sem. IV')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                        Forms\Components\TextInput::make('bing_5')
                            ->label('Sem. V')
                            ->numeric()
                            ->maxValue(100)
                            ->minValue(10),
                    ])
                    ->columns(5),
                Forms\Components\FileUpload::make('halaman_identitas')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),
                Forms\Components\FileUpload::make('halaman_nilai_semester')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(512)
                    ->downloadable(),

                Forms\Components\Fieldset::make('Jumlah Ketidakhadiran')
                    ->schema([
                        Forms\Components\TextInput::make('sakit')
                            ->numeric()
                            ->maxValue(99)
                            ->minValue(0),
                        Forms\Components\TextInput::make('izin')
                            ->numeric()
                            ->maxValue(99)
                            ->minValue(0),
                        Forms\Components\TextInput::make('alpa')
                            ->numeric()
                            ->maxValue(99)
                            ->minValue(0),
                    ])
                    ->columns(3),
                Forms\Components\FileUpload::make('halaman_kehadiran')
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

            $subjects = Rapor::SUBJECTS;

            foreach ($subjects as $subject) {
                $data[$subject] = Rapor::calculateTotal($data, $subject);
            }

            $totalMarks = array_intersect_key($data, array_flip($subjects));
            $data['sum'] = array_sum($totalMarks);
            $data['avg'] = $data['sum'] / (count($subjects) * 5);

            $this->getRecord()->rapor->update($data);

            Notification::make()->title('Data Rapor berhasil disimpan!')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }
}
