<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gelombang extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'gelombang';

    public $timestamps = false;

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function diterima()
    {
        return $this->pendaftaran()->where('status', StatusPendaftaran::LULUS);
    }

    public function jalur(): BelongsToMany
    {
        return $this->belongsToMany(Jalur::class);
    }

    public function tahunPelajaran(): BelongsTo
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function scopeAktifDibuka($query)
    {
        $query
            ->whereAktif(true)
            ->where('mulai', '<=', today())
            ->where('sampai', '>=', today());
    }

}
