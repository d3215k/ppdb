<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingSekolah extends Settings
{
    public ?string $nama;
    public ?string $logo;
    public ?string $kop_surat;
    public ?string $tahun_pelajaran_aktif;
    public ?string $nomor_hp_cs;
    public ?string $default_password;
    public bool $pelulusan;

    public static function group(): string
    {
        return 'sekolah';
    }
}
