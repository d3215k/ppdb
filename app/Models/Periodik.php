<?php

namespace App\Models;

use App\Enums\UkuranBaju;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periodik extends Model
{
    use HasFactory;

    protected $table = 'periodik';

    protected $casts = [
        'ukuran_baju' => UkuranBaju::class,
        'tato' => 'bool',
        'tindik' => 'bool',
        'cat_rambut' => 'bool',
    ];

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }
}
