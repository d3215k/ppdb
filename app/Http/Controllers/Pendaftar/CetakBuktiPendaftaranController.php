<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Settings\SettingSekolah;
use Illuminate\Http\Request;

class CetakBuktiPendaftaranController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SettingSekolah $setting)
    {
        $pendaftaran = Pendaftaran::query()
            ->aktif()->first();

        if (!$pendaftaran) {
            return to_route('pendaftar.dashboard');
        }

        return view('pendaftar.cetak', [
            'pendaftaran' => $pendaftaran,
            'setting' => $setting,
        ]);
    }
}
