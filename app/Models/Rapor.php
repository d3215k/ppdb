<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rapor extends Model
{
    use HasFactory;

    protected $table = 'rapor';

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }

    public function isComplete(): bool
    {
        return isset($this->halaman_identitas)
            & isset($this->halaman_nilai_semester)
            & isset($this->pai_1)
            & isset($this->pai_2)
            & isset($this->pai_3)
            & isset($this->pai_4)
            & isset($this->pai_5)
            & isset($this->bindo_1)
            & isset($this->bindo_2)
            & isset($this->bindo_3)
            & isset($this->bindo_4)
            & isset($this->bindo_5)
            & isset($this->mtk_1)
            & isset($this->mtk_2)
            & isset($this->mtk_3)
            & isset($this->mtk_4)
            & isset($this->mtk_5)
            & isset($this->ipa_1)
            & isset($this->ipa_2)
            & isset($this->ipa_3)
            & isset($this->ipa_4)
            & isset($this->ipa_5)
            & isset($this->ips_1)
            & isset($this->ips_2)
            & isset($this->ips_3)
            & isset($this->ips_4)
            & isset($this->ips_5)
            & isset($this->bing_1)
            & isset($this->bing_2)
            & isset($this->bing_3)
            & isset($this->bing_4)
            & isset($this->bing_5)
            & isset($this->halaman_kehadiran)
            & isset($this->sakit)
            & isset($this->izin)
            & isset($this->alpa)
        ;
    }

}
