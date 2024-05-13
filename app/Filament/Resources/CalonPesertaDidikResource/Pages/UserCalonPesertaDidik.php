<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Enums\UserType;
use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\CalonPesertaDidik;
use App\Models\User;
use App\Settings\SettingSekolah;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class UserCalonPesertaDidik extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = CalonPesertaDidikResource::class;

    protected static string $view = 'filament.resources.calon-peserta-didik-resource.pages.user-calon-peserta-didik';

    protected static ?string $title = 'Akses Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->getRecord()->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->getRecord()->asalSekolah->nama ?? '-';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Reset Password')
                ->icon('heroicon-m-lock-open')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(
                    fn (CalonPesertaDidik $record) => 'Reset Password ' . $record->name
                )
                ->modalDescription(fn (SettingSekolah $setting) => 'Setelah direset, password menjadi ' . $setting->default_password)
                ->action(fn (CalonPesertaDidik $record, SettingSekolah $setting) => $record->user->resetPassword($setting->default_password))
                ->hidden(fn () => ! $this->getRecord()->user),
            Action::make('Generate Akun Login')
                ->fillForm(fn (CalonPesertaDidik $record): array => [
                    'email' => $record->email,
                    'name' => $record->nama,
                ])
                ->form([
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                ])
                ->action(function (array $data, CalonPesertaDidik $record) {
                    $setting = new SettingSekolah();

                    $record->user()->create([
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'password' => bcrypt($setting->default_password),
                    ]);

                    return to_route('filament.app.resources.calon-peserta-didiks.user', $record);
                })
                ->hidden(fn () => $this->getRecord()->user),
        ];
    }

    private function fillForm()
    {
        $this->form->fill([
            'nomor_pendaftaran' => $this->getRecord()->nomor_pendaftaran,
            'username' => $this->getRecord()->username,
            'password' => $this->getRecord()->password,
            'email' => $this->getRecord()->user->email ?? null,
            'name' => $this->getRecord()->user->name ?? null,
        ]);
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->fillForm();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Akses Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignorable: fn () => $this->getRecord()->user,
                            )
                            ->validationMessages([
                                'unique' => 'Email sudah ada digunakan.',
                                'required' => 'Email wajib diisi.'
                            ])
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])->hidden(! $this->getRecord()->user),
                Forms\Components\Fieldset::make('Akun PPDB Dinas')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_pendaftaran')
                            ->maxLength(64),
                        Forms\Components\TextInput::make('username')
                            ->maxLength(64),
                        Forms\Components\TextInput::make('password')
                            ->maxLength(64),
                    ]),
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

            if ($this->getRecord()->user) {
                User::updateOrCreate(
                    [
                        'calon_peserta_didik_id' => $this->getRecord()->id,
                    ],
                    [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'type' => UserType::PENDAFTAR,
                    ]
                );
            }

            $this->getRecord()->update([
               'nomor_pendaftaran' =>  $data['nomor_pendaftaran'],
               'username' =>  $data['username'],
               'password' =>  $data['password'],
            ]);

            Notification::make()->title('Data User Pengguna berhasil disimpan!')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

}
