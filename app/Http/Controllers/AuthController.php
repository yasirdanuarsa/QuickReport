<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
    {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'petugas') {
            return redirect()->intended('/petugas/layouts');
        } else {
            return redirect('/'); // fallback jika role tidak dikenali
        }
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister()
    {
        return view('admin.products.register'); // file blade-nya akan dibuat di langkah berikutnya
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
{
    Auth::logout();
    return redirect()->route('login')->with('success', 'Berhasil logout.');
}
}
