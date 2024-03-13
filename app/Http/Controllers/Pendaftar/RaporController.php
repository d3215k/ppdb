<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('pendaftar.rapor');
    }
}
