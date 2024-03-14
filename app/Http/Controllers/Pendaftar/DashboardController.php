<?php

namespace App\Http\Controllers\Pendaftar;

use App\Enums\StatusPendaftaran;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pendaftaran = Pendaftaran::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)
            ->whereNotIn('status', [StatusPendaftaran::TIDAK_LULUS, StatusPendaftaran::MENGUNDURKAN_DIRI])
            ->first();

        return view('pendaftar.dashboard', [
            'pendaftaran' => $pendaftaran,
        ]);
    }
}
