<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ortu extends Model
{
    use HasFactory;

    protected $table = 'ortu';

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }
}
