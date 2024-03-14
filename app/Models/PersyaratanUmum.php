<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersyaratanUmum extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_umum';

    public $timestamps = false;

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function isComplete(): bool
    {
        $requiredProperties = [
            'dokumen_kelulusan',
            'dokumen_kelahiran',
            'kartu_keluarga',
            'ktp_ortu',
        ];

        foreach ($requiredProperties as $property) {
            if (!isset($this->$property)) {
                return false;
            }
        }

        return true;
    }
}
