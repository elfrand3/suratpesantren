<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Santri;

class SesiController extends Controller
{
    public function loginAkun(Request $request)
    {
    // Validasi input
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ], [
        'email.required' => 'Email belum diisi',
        'email.email' => 'Format email tidak valid',
        'password.required' => 'Password belum diisi',
    ]);

    // Simpan data login
    $infoLogin = [
        'email' => $validated['email'],
        'password' => $validated['password']
    ];

    // Coba login
    if (Auth::attempt($infoLogin)) {
        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        $role = Auth::user()->role;

        // Arahkan berdasarkan role
        if ($role === 'Admin') {
            return redirect(to:'/admin');
        } elseif ($role === 'Pengasuh') {
            return redirect(to:'/pengasuh');
        } else {
            Auth::logout(); // jika role tidak dikenali
            return back()->with('Error', 'Role tidak dikenali.');
        }

    } else {
        // Gagal login
        return back()->with('Error', 'Email atau Password salah')->withInput();
    }
    }

    public function logoutAkun(Request $request)
{
    Auth::logout(); // Logout user
    $request->session()->invalidate(); // Hapus semua data session
    $request->session()->regenerateToken(); // Buat CSRF token baru

    return redirect('/')->with('success', 'Anda telah logout.');
}
}
