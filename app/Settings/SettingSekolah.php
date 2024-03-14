<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingSekolah extends Settings
{
    public ?string $nama;
    public ?string $logo;
    public ?string $tahun_pelajaran_aktif;
    public ?string $nomor_hp_cs;

    public static function group(): string
    {
        return 'sekolah';
    }
}
