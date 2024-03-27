<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\Auditor;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    function index()
    {
        return view("login");
    }
    function login(Request $request)
{
    Session::flash('nrp', $request->nrp);
    $request->validate([
        'nrp' => 'required',
        'auditor_name' => 'required'
    ]);

    $nrp = $request->nrp;
    $auditor_name = $request->auditor_name;

    // Ambil auditor dari database berdasarkan NRP
    $auditor = Auditor::where('nrp', $nrp)->first();

    if ($auditor && $auditor->auditor_name === $auditor_name) {
        $auditor_level = $auditor->auditor_level;
        session(['logged_in_auditor' => $auditor_name]);
        session(['logged_in_auditor_level' => $auditor_level]);
        // Otentikasi berhasil
        // Auth::login($auditor); // Login user
        return redirect('checksheetcasting');
    } else {
        // Otentikasi gagal
        Session::flash('login_failed', 'Login failed! Please enter the correct NRP and auditor name.');
        return back();
    }
}

}
