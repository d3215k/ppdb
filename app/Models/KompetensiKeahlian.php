<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KompetensiKeahlian extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'kompetensi_keahlian';

    public function kuota(): BelongsToMany
    {
        return $this->belongsToMany(Jalur::class, 'kuota', 'kompetensi_keahlian_id', 'jalur_id')->withPivot('kuota');
    }

    public function pilihanPendaftaranKesatu(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'pilihan_kesatu');
    }

    public function pilihanPendaftaranKedua(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'pilihan_kedua');
    }

    public function diterima(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'kompetensi_keahlian')
            ->where('status', StatusPendaftaran::LULUS)
            ;
    }

}
