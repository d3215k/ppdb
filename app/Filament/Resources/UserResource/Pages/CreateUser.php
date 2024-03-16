<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserType;
use App\Filament\Resources\UserResource;
use App\Settings\SettingSekolah;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $setting = new SettingSekolah();

        $data['type'] = UserType::PANITIA;
        $data['password'] = bcrypt($setting->default_password);

        return $data;
    }
}
