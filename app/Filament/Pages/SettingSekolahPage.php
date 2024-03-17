<?php

namespace App\Filament\Pages;

use App\Events\TahunPelajaranAktifChanged;
use App\Models\TahunPelajaran;
use App\Settings\SettingSekolah;
use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class SettingSekolahPage extends SettingsPage
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = SettingSekolah::class;

    protected static ?string $title = 'Setting';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 6;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama'),
                Forms\Components\Select::make('tahun_pelajaran_aktif')
                    ->options(TahunPelajaran::pluck('nama', 'id')),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->maxSize(512)
                    ->nullable(),
                Forms\Components\FileUpload::make('kop_surat')
                    ->image()
                    ->maxSize(512)
                    ->nullable(),
                Forms\Components\TextInput::make('nomor_hp_cs')
                    ->label('Nomor Kontak Panitia')
                    ->required(),
                Forms\Components\TextInput::make('default_password')
                    ->required(),
                Forms\Components\ToggleButtons::make('pelulusan')
                    ->label('Aktifkan Pelulusan')
                    ->boolean()
                    ->inline()
                    ->grouped(),
            ]);
    }

    public function save(): void
    {
        parent::save();

        $data = $this->form->getState();

        $id = $data['tahun_pelajaran_aktif'];

        TahunPelajaran::query()
            ->where('id', $id)
            ->update([
                'aktif' => true
            ]);

        TahunPelajaran::query()
            ->whereNot('id', $id)
            ->update([
                'aktif' => false
            ]);

        TahunPelajaranAktifChanged::dispatch($id);
    }
}
