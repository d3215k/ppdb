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
    public function __invoke($nomor, SettingSekolah $setting)
    {
        $pendaftaran = Pendaftaran::query()
            ->where('nomor', $nomor)
            ->when(
                auth()->user()->isPendaftar,
                fn ($query) => $query->where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)
            )
            ->firstOrFail();

        // if (!$pendaftaran) {
        //     return to_route('pendaftar.dashboard');
        // }

        return view('pendaftar.cetak', [
            'pendaftaran' => $pendaftaran,
            'setting' => $setting,
        ]);
    }
}
