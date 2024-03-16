<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunPelajaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tahun_pelajaran';

    public $timestamps = false;

    public function gelombang(): HasMany
    {
        return $this->hasMany(Gelombang::class);
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function diterima()
    {
        return $this->pendaftaran()->where('status', StatusPendaftaran::LULUS);
    }

}
