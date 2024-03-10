<?php

namespace App\Support;

use App\Enums\SequenceType;
use App\Models\Sequence;
use App\Settings\SertifikatSetting;

class GenerateNumber
{
    public static function pendaftaran($tahun, $gelombang)
    {
        $seq = Sequence::firstOrCreate([
            'fy' => $tahun->id,
        ]);

        $seq->increment('current');

        $nextNumber = str_pad($seq->current, 5, '0', STR_PAD_LEFT);

        $registrationNumber = "{$tahun->kode}.{$gelombang->kode}.{$nextNumber}";

        return $registrationNumber;
    }

}
