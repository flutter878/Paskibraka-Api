<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $credentials = [
            $field => $request->login,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login' => 'NIK/Email atau password salah.',
            ])->withInput();
        }

            if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
            'login' => 'Akun ini bukan admin.',
        ]);
}

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
