<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jalur extends Model
{
    use HasFactory;

    protected $table = 'jalur';

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function gelombang(): BelongsToMany
    {
        return $this->belongsToMany(Gelombang::class);
    }

}
