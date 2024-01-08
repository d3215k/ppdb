<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sekolah.nama', 'SMKN 1 CIBADAK SUKABUMI');
        $this->migrator->add('sekolah.logo', null);
    }
};
