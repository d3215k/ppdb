<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempatTinggal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ref_tempat_tinggal';

    public $timestamps = false;

    public function calonPesertaDidik(): HasOne
    {
        return $this->hasOne(CalonPesertaDidik::class);
    }

}
