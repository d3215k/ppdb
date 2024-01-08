<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsalSekolah extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asal_sekolah';

    public function calonPesertaDidik(): HasMany
    {
        return $this->hasMany(CalonPesertaDidik::class);
    }
}
