<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalAccessController extends Controller
{
    public function index()
    {
        return view('internal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password === 'MutiraoAmigo') {
            session(['internal_access' => true]);
            return redirect()->route('internal.dashboard');
        }

        return back()->withErrors(['password' => 'Senha incorreta.']);
    }

    public function dashboard()
    {
        if (!session('internal_access')) {
            return redirect()->route('internal.login');
        }

        return view('internal.dashboard');
    }
}
