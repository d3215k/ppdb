<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ayah extends Model
{
    use HasFactory;

    protected $table = 'ortu';

    public function calonPesertaDidik(): HasOne
    {
        return $this->hasOne(CalonPesertaDidik::class);
    }
}
