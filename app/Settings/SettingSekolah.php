<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingSekolah extends Settings
{
    public string $nama;
    public string $logo;

    public static function group(): string
    {
        return 'sekolah';
    }
}
