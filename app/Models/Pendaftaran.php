<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Pendaftaran extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'pendaftaran';

    protected $casts = [
        'status' => StatusPendaftaran::class
    ];

    public function tahunPelajaran(): BelongsTo
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }

    public function rapor(): HasOneThrough
    {
        return $this->hasOneThrough(Rapor::class, CalonPesertaDidik::class);
    }

    public function jalur(): BelongsTo
    {
        return $this->belongsTo(Jalur::class);
    }

    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function pilihanKesatu(): BelongsTo
    {
        return $this->belongsTo(KompetensiKeahlian::class, 'pilihan_kesatu');
    }

    public function pilihanKedua(): BelongsTo
    {
        return $this->belongsTo(KompetensiKeahlian::class, 'pilihan_kedua');
    }

    public function buktiPersyaratanKhusus(): HasMany
    {
        return $this->hasMany(BuktiPersyaratanKhusus::class);
    }
}
