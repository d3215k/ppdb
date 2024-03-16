<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use App\Enums\StatusPendaftaran;
use App\Traits\WithTahunPelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CalonPesertaDidik extends Model
{
    use HasFactory;
    use WithTahunPelajaran;

    protected $casts = [
        'lp' => JenisKelamin::class
    ];

    protected $table = 'calon_peserta_didik';

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class)
            ->where('tahun_pelajaran_id', session('tahun_pelajaran_id'));
    }

    public function getWhatsappLink()
    {
        $nomor = $this->nomor_hp;
        if (substr($nomor, 0, 2) == '08') {
            $nomor = substr_replace($nomor, '62', 0, 1);
        }

        return "https://wa.me/" . $nomor;
    }

    public function kompetensiKeahlian(): HasOne
    {
        return $this->pendaftaran()
            ->where('status', StatusPendaftaran::LULUS)
            ->first();
    }

    public function scopeWithPendaftaranAktif($query)
    {
        $query
            ->addSelect([
            'pendaftaranAktif' => Pendaftaran::whereColumn('calon_peserta_didik_id', 'calon_peserta_didik.id')
                ->whereNotIn('status', [StatusPendaftaran::MENGUNDURKAN_DIRI, StatusPendaftaran::TIDAK_LULUS])
                ->take(1)
            ]);
    }

    public function getAlamatLengkapAttribute()
    {
        return $this->alamat . ' RT ' . $this->rt . ' RW ' . $this->rw . ' Desa/Kelurahan ' . $this->desa_kelurahan . ' Kecamatan ' . $this->kecamatan;
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

    public function ortu(): HasOne
    {
        return $this->hasOne(Ortu::class);
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
