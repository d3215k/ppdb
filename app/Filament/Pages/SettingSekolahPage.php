<?php

namespace App\Filament\Pages;

use App\Events\TahunPelajaranAktifChanged;
use App\Models\TahunPelajaran;
use App\Settings\SettingSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class SettingSekolahPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = SettingSekolah::class;

    protected static ?string $title = 'Setting';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 4;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama'),
                Forms\Components\Select::make('tahun_pelajaran_aktif')
                    ->options(TahunPelajaran::pluck('nama', 'id')),
                Forms\Components\FileUpload::make('logo')
                    ->nullable(),
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
