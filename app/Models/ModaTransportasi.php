<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModaTransportasi extends Model
{
    use HasFactory;

    protected $table = 'ref_moda_transportasi';

    public function calonPesertaDidik()
    {
        return $this->hasMany(CalonPesertaDidik::class);
    }
}
