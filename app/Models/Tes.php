<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tes extends Model
{
    use HasFactory;

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class, 'calon_peserta_didik_id');
    }
}
