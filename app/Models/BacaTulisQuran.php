<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BacaTulisQuran extends Model
{
    use HasFactory;

    protected $table = 'baca_tulis_quran';

    public function penguji(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
