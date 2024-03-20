<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UkuranSepatu: int implements HasLabel
{
    case __35 = 35;
    case __36 = 36;
    case __37 = 37;
    case __38 = 38;
    case __39 = 39;
    case __40 = 40;
    case __41 = 41;
    case __42 = 42;
    case __43 = 43;
    case __44 = 44;
    case __45 = 45;
    case __46 = 46;
    case __47 = 47;
    case __48 = 48;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::__35 => '35',
            self::__36 => '36',
            self::__37 => '37',
            self::__38 => '38',
            self::__39 => '39',
            self::__40 => '40',
            self::__41 => '41',
            self::__42 => '42',
            self::__43 => '43',
            self::__44 => '44',
            self::__45 => '45',
            self::__46 => '46',
            self::__47 => '47',
            self::__48 => '48',
        };
    }
}
