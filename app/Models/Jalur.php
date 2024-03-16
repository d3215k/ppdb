<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use App\Observers\JalurObserver;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([JalurObserver::class])]
class Jalur extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'jalur';

    public $timestamps = false;

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function diterima()
    {
        return $this->pendaftaran()->where('status', StatusPendaftaran::LULUS);
    }

    public function gelombang(): BelongsToMany
    {
        return $this->belongsToMany(Gelombang::class);
    }

    public function persyaratanKhusus(): HasMany
    {
        return $this->hasMany(PersyaratanKhusus::class);
    }

    public function kuota(): BelongsToMany
    {
        return $this->belongsToMany(KompetensiKeahlian::class, 'kuota', 'jalur_id', 'kompetensi_keahlian_id')->withPivot('kuota');
    }

}
