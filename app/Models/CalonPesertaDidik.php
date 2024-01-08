<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalonPesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'calon_peserta_didik';

    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class);
    }

    public function berkebutuhanKhusus(): BelongsTo
    {
        return $this->belongsTo(BerkebutuhanKhusus::class);
    }

    public function tempatTinggal(): BelongsTo
    {
        return $this->belongsTo(TempatTinggal::class);
    }

    public function modaTransportasi(): BelongsTo
    {
        return $this->belongsTo(ModaTransportasi::class);
    }

    public function ayah(): HasOne
    {
        return $this->hasOne(Ayah::class);
    }

    public function ibu(): HasOne
    {
        return $this->hasOne(Ibu::class);
    }

    public function wali(): HasOne
    {
        return $this->hasOne(Wali::class);
    }

    public function asalSekolah(): BelongsTo
    {
        return $this->belongsTo(AsalSekolah::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
