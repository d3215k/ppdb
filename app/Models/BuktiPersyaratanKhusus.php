<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPersyaratanKhusus extends Model
{
    use HasFactory;

    protected $table = 'bukti_persyaratan_khusus';

    public function persyaratanKhusus(): BelongsTo
    {
        return $this->belongsTo(PersyaratanKhusus::class);
    }

}
