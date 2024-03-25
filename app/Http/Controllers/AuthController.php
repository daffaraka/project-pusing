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
            'nrp'=>'required',
            'auditor_name'=>'required'

        ]);
        // dd(session('logged_in_auditor'));
        
        $nrp = $request->nrp;
        $auditor_name = $request->auditor_name;
        
        // Ambil auditor dari database berdasarkan NRP
        $auditor = Auditor::where('nrp', $nrp)->first();
        session(['logged_in_auditor' => $request->auditor_name]);
        $logged_in_auditor = session('logged_in_auditor');
        $auditor = Auditor::where('auditor_name', $logged_in_auditor)->first();
        $auditor_level = $auditor->auditor_level;
        session(['logged_in_auditor_level' => $auditor_level]);
        // dd(session('logged_in_auditor_level'));
        if ($auditor && $auditor->auditor_name === $auditor_name) {
            // Otentikasi berhasil
            // Auth::login($auditor); // Login user
            return redirect('checksheetcasting');
        } else {
            // Otentikasi gagal
            Session::flash('login_failed', '"Login failed! Please enter the correct NRP and auditor name."');
            return back();
        }
    }
}
