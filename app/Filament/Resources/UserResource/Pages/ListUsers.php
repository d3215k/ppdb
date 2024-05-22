<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserType;
use App\Filament\Resources\UserResource;
use App\Models\CalonPesertaDidik;
use App\Models\User;
use App\Settings\SettingSekolah;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate')
                ->label('Generate Akun Pendaftar')
                ->action(function () {
                    try {
                        $ids = User::query()
                            ->whereNotNull('calon_peserta_didik_id')
                            // ->where('type', UserType::PENDAFTAR)
                            ->pluck('calon_peserta_didik_id');

                        $cpd = CalonPesertaDidik::query()
                            ->whereNotIn('id', $ids)
                            ->whereNotNull('email')
                            ->get();

                        $setting = new SettingSekolah();

                        foreach ($cpd as $pendaftar) {
                            User::updateOrCreate(
                                [
                                    'calon_peserta_didik_id' => $pendaftar->id,
                                ],
                                [
                                    'email' => $pendaftar->email,
                                    'name' => $pendaftar->nama,
                                    'password' => $setting->default_password,
                                    'type' => UserType::PENDAFTAR,
                                ]
                            );
                        }

                        Notification::make()->title('Berhasil!')->body($cpd->count().' akun pendaftar baru dibuat.')->success()->send();
                    } catch (\Throwable $th) {
                        report($th->getMessage());
                        Notification::make()->title('Whoops!')->body('Ada yang salah.')->danger()->send();
                    }
                })
                ->requiresConfirmation(),
            Actions\CreateAction::make()
                ->label('Buat Akun Pengguna'),
        ];
    }
}
