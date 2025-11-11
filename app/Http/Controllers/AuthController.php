<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            // Simpan user baru ke database
            User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
                'role'=> 'user'
            ]);

            // Jika berhasil, arahkan ke login dengan notifikasi sukses
            return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
        } catch (\Exception $e) {
            // Jika gagal (misal error DB), tampilkan notifikasi error
            return back()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/user/dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
