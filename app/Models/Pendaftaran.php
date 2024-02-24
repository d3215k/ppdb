<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    public function tahunPelajaran(): BelongsTo
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function jalur(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class);
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
