<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Rapor extends Model
{
    use HasFactory;

    protected $table = 'rapor';

    public function calonPesertaDidik(): BelongsTo
    {
        return $this->belongsTo(CalonPesertaDidik::class);
    }

    public function getTotalAttribute()
    {
        $subjects = ['pai', 'bindo', 'mtk', 'ipa', 'ips', 'bing'];
        $total = 0;

        foreach ($subjects as $subject) {
            for ($i = 1; $i <= 5; $i++) {
                $total += $this->{$subject . '_' . $i};
            }
        }

        return $total;
    }

    public function getAverageAttribute()
    {
        $subjects = ['pai', 'bindo', 'mtk', 'ipa', 'ips', 'bing'];
        $total = 0;
        $count = 0;

        foreach ($subjects as $subject) {
            for ($i = 1; $i <= 5; $i++) {
                $total += $this->{$subject . '_' . $i};
                $count++;
            }
        }

        return $total / $count;
    }

    private function calculateTotal($subject)
    {
        $total = 0;

        for ($i = 1; $i <= 5; $i++) {
            $total += $this->{$subject . '_' . $i};
        }

        return $total;
    }

    public function getPaiAttribute()
    {
        return $this->calculateTotal('pai');
    }

    public function getBindoAttribute()
    {
        return $this->calculateTotal('bindo');
    }

    public function getMtkAttribute()
    {
        return $this->calculateTotal('mtk');
    }

    public function getIpaAttribute()
    {
        return $this->calculateTotal('ipa');
    }

    public function getIpsAttribute()
    {
        return $this->calculateTotal('ips');
    }

    public function getBingAttribute()
    {
        return $this->calculateTotal('bing');
    }

    public function isComplete(): bool
    {
        $requiredProperties = [
            'halaman_identitas',
            'halaman_nilai_semester',
            'pai_1',
            'pai_2',
            'pai_3',
            'pai_4',
            'pai_5',
            'bindo_1',
            'bindo_2',
            'bindo_3',
            'bindo_4',
            'bindo_5',
            'mtk_1',
            'mtk_2',
            'mtk_3',
            'mtk_4',
            'mtk_5',
            'ipa_1',
            'ipa_2',
            'ipa_3',
            'ipa_4',
            'ipa_5',
            'ips_1',
            'ips_2',
            'ips_3',
            'ips_4',
            'ips_5',
            'bing_1',
            'bing_2',
            'bing_3',
            'bing_4',
            'bing_5',
            'halaman_kehadiran',
            'sakit',
            'izin',
            'alpa',
        ];

        foreach ($requiredProperties as $property) {
            if (!isset($this->$property)) {
                return false;
            }
        }

        return true;
    }

}
