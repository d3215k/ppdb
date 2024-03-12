<?php
namespace App\Traits;

use App\Models\Scopes\AktifTahunPelajaranScope;
use Illuminate\Database\Eloquent\Model;

trait WithTahunPelajaran {

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            if ( ! $model->tahun_pelajaran_id) {
                $model->tahun_pelajaran_id = session('tahun_pelajaran_id');
            }
        });
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AktifTahunPelajaranScope);
    }

}
