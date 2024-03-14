<?php

namespace App\Models;

use App\Enums\StatusPendaftaran;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalonPesertaDidik extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $table = 'calon_peserta_didik';

    public function pendaftaran(): HasOne
    {
        return $this->hasOne(Pendaftaran::class)
            ->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
    }

    public function kompetensiKeahlian(): HasOne
    {
        return $this->pendaftaran()
            ->where('status', StatusPendaftaran::LULUS)
            ->first();
    }

    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class);
    }

    public function berkebutuhanKhusus(): BelongsTo
    {
        return $this->belongsTo(BerkebutuhanKhusus::class);
    }

    public function tempatTinggal(): BelongsTo
    {
        return $this->belongsTo(TempatTinggal::class);
    }

    public function modaTransportasi(): BelongsTo
    {
        return $this->belongsTo(ModaTransportasi::class);
    }

    public function periodik(): HasOne
    {
        return $this->hasOne(Periodik::class);
    }

    public function ayah(): HasOne
    {
        return $this->hasOne(Ayah::class);
    }

    public function ibu(): HasOne
    {
        return $this->hasOne(Ibu::class);
    }

    public function wali(): HasOne
    {
        return $this->hasOne(Wali::class);
    }

    public function asalSekolah(): BelongsTo
    {
        return $this->belongsTo(AsalSekolah::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function btq(): HasOne
    {
        return $this->hasOne(BacaTulisQuran::class);
    }

    public function tes(): HasOne
    {
        return $this->hasOne(Tes::class);
    }

    public function rapor(): HasOne
    {
        return $this->hasOne(Rapor::class);
    }

    public function persyaratanUmum(): HasOne
    {
        return $this->hasOne(PersyaratanUmum::class);
    }

    public function isComplete(): bool
    {
        $requiredProperties = [
            'nama',
            'lp',
            'nisn',
            'kewarganegaraan',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'agama_id',
            'alamat',
            'desa_kelurahan',
            'tempat_tinggal_id',
            'moda_transportasi_id',
            'anak_ke',
            'nomor_hp',
            'email',
            'asal_sekolah_id',
            'username',
            'password',
        ];

        foreach ($requiredProperties as $property) {
            if (!isset($this->$property)) {
                return false;
            }
        }

        return true;
    }
}
