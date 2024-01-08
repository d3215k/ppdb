<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasi';

    public function tahunPelajaran(): BelongsTo
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function jalurPendaftaran(): BelongsTo
    {
        return $this->belongsTo(JalurPendaftaran::class);
    }

    public function gelombangPendaftaran(): BelongsTo
    {
        return $this->belongsTo(GelombangPendaftaran::class);
    }

    public function pilihanKesatu(): BelongsTo
    {
        return $this->belongsTo(KompetensiKeahlian::class);
    }

    public function pilihanKedua(): BelongsTo
    {
        return $this->belongsTo(KompetensiKeahlian::class);
    }
}
