<?php

namespace App\Models;

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
        return isset($this->nama)
            & isset($this->lp)
            & isset($this->nisn)
            & isset($this->kewarganegaraan)
            & isset($this->nik)
            & isset($this->tempat_lahir)
            & isset($this->tanggal_lahir)
            & isset($this->agama_id)
            & isset($this->alamat)
            & isset($this->desa_kelurahan)
            & isset($this->tempat_tinggal_id)
            & isset($this->moda_transportasi_id)
            & isset($this->anak_ke)
            & isset($this->nomor_hp)
            & isset($this->email)
            & isset($this->asal_sekolah_id)
            & isset($this->username)
            & isset($this->password)
            ;
    }
}
