<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        // 🔥 DESTRÓI A SESSÃO
        $request->session()->invalidate();

        // 🔐 GERA NOVO TOKEN
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
