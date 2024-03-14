<?php

namespace App\Http\Controllers\Pendaftar;

use App\Enums\StatusPendaftaran;
use App\Http\Controllers\Controller;
use App\Models\Gelombang;
use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $gelombang = Gelombang::query()
            ->aktifDibuka()
            ->get();

        $pengumuman = Pengumuman::all();

        $pendaftaran = Pendaftaran::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)
            ->whereNotIn('status', [StatusPendaftaran::TIDAK_LULUS, StatusPendaftaran::MENGUNDURKAN_DIRI])
            ->first();

        return view('pendaftar.dashboard', [
            'pendaftaran' => $pendaftaran,
            'pengumuman' => $pengumuman,
            'gelombang' => $gelombang,
        ]);
    }
}
