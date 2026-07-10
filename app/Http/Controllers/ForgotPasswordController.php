<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('lupa_password'); // Pastikan file 'lupa_password.blade.php' ada di resources/views
    }
    public function verifikasiData(Request $request) {
    // Debugging: Hapus baris ini setelah tahu datanya benar
    // dd($request->all()); 

    $user = User::where('role', $request->role)
                ->where('identity_number', $request->identity)
                ->where('phone', $request->phone)
                ->first();

    if ($user) {
        return response()->json(['status' => 'success'], 200);
    }
    
    // Jika sampai di sini, artinya tidak ditemukan
    return response()->json(['status' => 'error'], 404);
}
public function updatePassword(Request $request) {
    // 1. Cari user berdasarkan identity
    $user = User::where('identity_number', $request->identity)->first();

    if ($user) {
        // 2. Update password
        $user->password = bcrypt($request->password);
        $user->save();

        // 3. Kirim respon sukses ke AJAX
        return response()->json(['message' => 'Password berhasil diganti'], 200);
    }

    // 4. Jika user tidak ditemukan
    return response()->json(['message' => 'User tidak ditemukan'], 404);
}
}