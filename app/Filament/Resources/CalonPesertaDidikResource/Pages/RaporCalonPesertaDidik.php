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
