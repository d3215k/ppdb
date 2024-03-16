<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
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

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class, 'calon_peserta_didik_id');
    }

    // public function scopeWithPilihanPertama($query)
    // {
    //     $query
    //         ->join('calon_peserta_didik', 'baca_tulis_quran.calon_peserta_didik_id', '=', 'calon_peserta_didik.id')
    //         ->addSelect([
    //             'pendaftaranAktif' => Pendaftaran::select('pilihan_kesatu')->whereColumn('calon_peserta_didik_id', 'calon_peserta_didik.id')
    //                 ->whereNotIn('status', [StatusPendaftaran::MENGUNDURKAN_DIRI, StatusPendaftaran::TIDAK_LULUS])
    //                 ->take(1)
    //         ]);
    // }
}
