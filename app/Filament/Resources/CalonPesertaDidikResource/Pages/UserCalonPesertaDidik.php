<?php

namespace App\Filament\Resources\CalonPesertaDidikResource\Pages;

use App\Enums\UserType;
use App\Filament\Resources\CalonPesertaDidikResource;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

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

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill([
            ...$this->getRecord()->toArray(),
            'email' => $this->getRecord()->user->email ?? null,
            'name' => $this->getRecord()->user->name ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Akses Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->default($this->getRecord()->email)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255),
                    ]),
                Forms\Components\Fieldset::make('Akun PPDB Dinas')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->maxLength(255),
                    ]),
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

            $this->getRecord()->update([
               'username' =>  $data['username'],
               'password' =>  $data['password'],
            ]);

            Notification::make()->title('Data Rapor berhasil disimpan!')->success()->send();

            DB::commit();
        } catch (\Throwable $th) {
            Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
            DB::rollBack();
            report($th->getMessage());
        }
    }

}
