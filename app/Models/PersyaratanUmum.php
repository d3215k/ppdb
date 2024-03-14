<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersyaratanUmum extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_umum';

    public $timestamps = false;

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function isComplete(): bool
    {
        return isset($this->dokumen_kelulusan)
            & isset($this->dokumen_kelahiran)
            & isset($this->kartu_keluarga)
            & isset($this->ktp_ortu)
            ;
    }
}
