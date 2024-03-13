<?php

namespace App\Http\Controllers\Pendaftar;

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
        $pendaftaran = Pendaftaran::where('calon_peserta_didik_id', auth()->user()->calon_peserta_didik_id)->get();

        return view('pendaftar.dashboard', [
            'pendaftaran' => $pendaftaran,
        ]);
    }
}
