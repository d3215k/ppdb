<?php

namespace App\Models;

use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KompetensiKeahlian extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'kompetensi_keahlian';

    public function kuota(): BelongsToMany
    {
        return $this->belongsToMany(Jalur::class, 'kuota', 'kompetensi_keahlian_id', 'jalur_id')->withPivot('kuota');
    }

}
