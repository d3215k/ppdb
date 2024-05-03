<?php

namespace App\Filament\Clusters;

use App\Traits\EnsureOnlyAdminCanAccess;
use Filament\Clusters\Cluster;

class ReferensiData extends Cluster
{
    use EnsureOnlyAdminCanAccess;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 6;
}
