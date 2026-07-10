<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User; // Pastikan model User di-import

class loginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); 
    }

    public function login(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'identity' => 'required',
            'password' => 'required',
            'role'     => 'required'
        ]);

        // 2. Mencari user berdasarkan identity_number dan role
        // Gunakan 'identity_number' sesuai dengan nama kolom di database Anda
        $user = User::where('identity_number', $request->identity)
                    ->where('role', $request->role)
                    ->first();

        // 3. Verifikasi Password
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Login user secara resmi menggunakan sistem Auth Laravel
            Auth::login($user);
            
            $request->session()->regenerate();
            
            // Arahkan ke dashboard berdasarkan role
            // Ubah menjadi seperti ini agar selalu huruf kecil
return redirect('/dashboard_' . strtolower($user->role));
        }

        // 4. Jika gagal
        return back()->withErrors([
            'identity' => 'Maaf password anda salah, masukkan password dengan benar!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}