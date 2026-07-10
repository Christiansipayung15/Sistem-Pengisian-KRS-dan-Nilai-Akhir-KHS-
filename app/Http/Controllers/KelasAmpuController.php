<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasAmpuController extends Controller
{
   public function create() 
{
    // Mengambil semua data dari database untuk ditampilkan di dropdown
    $matakuliahs = \App\Models\Matakuliah::all();
    $dosens = \App\Models\Dosen::all();
    
    return view('admin.tambah_kelas', compact('matakuliahs', 'dosens'));
}
public function store(Request $request) {
    \App\Models\KelasAmpu::create([
        'kode_mk' => $request->kode_mk,
        'nip_dosen' => $request->nip_dosen,
        'semester_buka' => $request->semester_buka,
    ]);
    return redirect()->back()->with('success', 'Kelas berhasil dibuka!');
}
}
