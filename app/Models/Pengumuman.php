<?php

namespace App\Models;

use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'pengumuman';

    protected $casts = [
        'terbit' => 'datetime'
    ];

    public function informan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
