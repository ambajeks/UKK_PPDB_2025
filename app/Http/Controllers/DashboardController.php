<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika admin, arahkan ke dashboard admin
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Jika user biasa
        return view('dashboard');
    }
}
