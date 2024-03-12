<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingSekolah extends Settings
{
    public string $nama;
    public string $tahun_pelajaran_aktif;
    public ?string $logo;

    public static function group(): string
    {
        return 'sekolah';
    }
}
