<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BerkebutuhanKhusus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ref_berkebutuhan_khusus';

    public $timestamps = false;

    public function calonPesertaDidik(): HasMany
    {
        return $this->hasMany(CalonPesertaDidik::class);
    }

}
