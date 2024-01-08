<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersyaratanUmum extends Model
{
    use HasFactory;

    public function registrasi(): BelongsTo
    {
        return $this->belongsTo(Registrasi::class);
    }
}
