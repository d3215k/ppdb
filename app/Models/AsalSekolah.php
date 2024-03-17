<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsalSekolah extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asal_sekolah';

    public $timestamps = false;

    public function calonPesertaDidik(): HasMany
    {
        return $this->hasMany(CalonPesertaDidik::class);
    }

    public function pendaftaran(): HasManyThrough
    {
        return $this->hasManyThrough(Pendaftaran::class, CalonPesertaDidik::class);
    }

    public function diterima(): HasManyThrough
    {
        return $this->pendaftaran()->where('status', StatusPendaftaran::LULUS);
    }
}
