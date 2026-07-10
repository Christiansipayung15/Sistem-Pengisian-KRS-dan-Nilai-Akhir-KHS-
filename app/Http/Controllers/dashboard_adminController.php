<?php


namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Matakuliah; // Pastikan model ini di-import di bagian atas
use App\Models\User; // Pastikan model User diimpor
use Illuminate\Http\Request;
class dashboard_adminController extends Controller
{
    public function exportKrsPdf() {
    // Ambil data KRS mahasiswa yang sedang login
    $user = auth()->user();
    $krsData = \App\Models\Krs::where('user_id', $user->id)->get(); 

    // Load view khusus untuk tampilan PDF
    $pdf = Pdf::loadView('pdf.krs', ['user' => $user, 'krs' => $krsData]);

    // Download file PDF
    return $pdf->download('KRS_' . $user->name . '.pdf');
}
public function index(Request $request) 
{
    // 1. Data Statis & Statistik
    $matakuliahs = \App\Models\Matakuliah::with('dosen')->get();
    $users = \App\Models\User::all();
    $all_dosens = \App\Models\User::where('role', 'dosen')->get(); 
    
    $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')->count();
    $totalDosen = \App\Models\User::where('role', 'dosen')->count();
    $totalMatkul = \App\Models\Matakuliah::count();

    // 2. Inisialisasi variabel agar tidak error saat view dipanggil tanpa filter
    $dosenWali = collect(); // Menggunakan collection kosong
    $mahasiswas = collect();

    // 3. Logika Filter Kelas
   if ($request->has('kelas') && !empty($request->kelas)) {
    $kelas = $request->kelas;

    // 1. Ambil Dosen Wali dengan Join ke tabel kelas_dosen_wali
    // Asumsi: tabel kelas_dosen_wali memiliki kolom 'user_id' dan 'kelas_nama'
    $dosenWali = \App\Models\User::join('kelas_dosen_wali', 'users.id', '=', 'kelas_dosen_wali.user_id')
                    ->where('users.role', 'dosen')
                    ->where('kelas_dosen_wali.kelas_nama', $kelas)
                    ->select('users.*') // Ambil data user (termasuk nama)
                    ->get();
                    
    // 2. Ambil Mahasiswa (Jika kolom kelas mahasiswa masih di tabel users)
   $mahasiswas = User::where('role', 'mahasiswa')
                          ->where('kelas', $kelas) // Tambahkan where agar sesuai kelas
                          ->with('nilai') 
                          ->get();

        foreach ($mahasiswas as $mhs) {
            $nilaiMhs = optional($mhs->nilai);
            $totalSks = $nilaiMhs->sum('sks') ?: 1;
            $totalBobot = $nilaiMhs->sum(function($n) {
                return $n->bobot * $n->sks;
            });

            $mhs->ips = ($totalSks > 0) ? ($totalBobot / $totalSks) : 0;
            $mhs->ipk = $mhs->ips; 
        }
    } // <-- TUTUP KURUNG KURAWAL 'if' DI SINI

    // 4. Compact data
    return view('dashboard_admin', compact(
        'matakuliahs', 
        'users', 
        'all_dosens', 
        'totalMahasiswa', 
        'totalDosen', 
        'totalMatkul',
        'dosenWali', 
        'mahasiswas'
    ));
}
public function updateKelas(Request $request) 
{
    $dosenId = $request->id;
    $kelasBaru = $request->kelas;

    // 1. CEK DUPLIKASI: Apakah kelas ini sudah dimiliki dosen lain?
    $cekKelas = \DB::table('kelas_dosen_wali')
                    ->where('kelas_nama', $kelasBaru)
                    ->where('user_id', '!=', $dosenId)
                    ->first();

    if ($cekKelas) {
        return response()->json([
            'success' => false, 
            'message' => 'Gagal! Kelas ' . $kelasBaru . ' sudah dipegang oleh dosen lain.'
        ], 400); // Status 400 memicu error di JavaScript
    }

    // 2. PROSES HAPUS & SIMPAN (Jika kelas kosong, berarti menghapus kelas)
    \DB::table('kelas_dosen_wali')->where('user_id', $dosenId)->delete();

    if (!empty($kelasBaru)) {
        \DB::table('kelas_dosen_wali')->insert([
            'user_id' => $dosenId,
            'kelas_nama' => $kelasBaru
        ]);
    }
    
    return response()->json(['success' => true, 'message' => 'Kelas berhasil diperbarui!']);
}
// Tambahkan fungsi ini di dalam class dashboard_adminController
public function updatePeran(Request $request, $id) 
{
    // 1. Cek apakah role yang dipilih adalah 'Dosen Wali'
    // Sesuaikan 'Dosen Wali' dengan nilai yang ada di database Anda
    if ($request->role == 'Dosen Wali') { 
        
        // 2. Hitung jumlah user yang sudah memiliki role 'Dosen Wali'
        $jumlahDosenWali = User::where('role', 'Dosen Wali') // Gunakan 'role' sesuai kode Anda
                                ->where('id', '!=', $id) 
                                ->count();

        // 3. Jika sudah mencapai 2, hentikan proses
        if ($jumlahDosenWali >= 3) {
            return redirect()->back()->with('error', 'Maaf, kuota Dosen Wali sudah penuh (maksimal 3 orang).');
        }
    }

    // 4. Jika kuota aman, simpan perubahan
    $user = User::findOrFail($id);
    $user->update(['role' => $request->role]); // Update kolom 'role'
    
    return redirect()->back()->with('success', 'Peran berhasil diperbarui.');
}
// Tambahkan ini di dalam class dashboard_adminController
public function updateTipe(Request $request)
{
    // 1. Cek apakah role yang dipilih adalah 'wali' (Dosen Wali)
    if ($request->tipe_dosen == 'wali') {
        
        // 2. Hitung jumlah user yang sudah memiliki tipe_dosen 'wali'
        // Kecualikan user yang sedang diupdate
        $jumlahDosenWali = User::where('tipe_dosen', 'wali')
                                ->where('id', '!=', $request->id) 
                                ->count();

        // 3. Batasi maksimal 3
        if ($jumlahDosenWali >= 3) {
            return response()->json(['success' => false, 'message' => 'Maaf, dosen wali hanya maksimal 3!'], 400);
        }
    }

    // 4. Lanjut proses simpan jika kuota aman
    $user = User::find($request->id);
    if ($user) {
        $user->tipe_dosen = $request->tipe_dosen;
        $user->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 404);
}

    public function store(Request $request) {
        User::create([
            'name' => $request->name,
            'identity_number' => $request->identity_number,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambah!');
    }
    public function storeMatakuliah(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'kode_mk' => 'required|unique:mata_kuliah,kode_mk',
        'nama_mk' => 'required',
        'sks' => 'required|numeric',
        'semester' => 'required|numeric',
        'dosen_id' => 'required',
    ]);

    // 2. Simpan ke model MataKuliah
    \App\Models\Matakuliah::create($request->all());

    // 3. Redirect kembali ke halaman dengan pesan sukses
    return redirect()->back()->with('success', 'Data mata kuliah berhasil ditambahkan!');
}
public function edit($id) {
    $user = User::findOrFail($id);
    return response()->json($user); // Mengirim data user dalam format JSON untuk modal
}
public function show($id) 
{
    // Cari user utama
    $user = \App\Models\User::findOrFail($id);

    // Jika perannya adalah dosen, ambil data kelas dari tabel kelas_dosen_wali
    $kelasDosen = null;
    if ($user->role === 'dosen') {
        $kelasDosen = \DB::table('kelas_dosen_wali')
                        ->where('user_id', $id)
                        ->value('kelas_nama'); // Mengambil nilai kelas_nama
    }

    // Mengirim data ke JSON agar bisa dibaca JavaScript
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        // Jika dosen, kirim data dari tabel wali. Jika mahasiswa, ambil kolom kelas biasa.
        'kelas_tampil' => ($user->role === 'dosen') ? ($kelasDosen ?? '-') : ($user->kelas ?? '-')
    ]);
}

public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'role' => $request->role,
    ]);
    return redirect()->back()->with('success', 'Data berhasil diperbarui!');
}
// Selesai dengan fungsi sebelumnya
   // Selesai dengan fungsi sebelumnya
    public function destroyMatakuliah($kode_mk)
    {
        $matakuliah = \App\Models\Matakuliah::where('kode_mk', $kode_mk)->firstOrFail();
        $matakuliah->delete();
        return redirect()->back()->with('success', 'Mata kuliah berhasil dihapus!');
    } // <-- Pastikan ada kurung tutup di sini

    // Fungsi baru dimulai di luar kurung kurawal fungsi sebelumnya
// Pastikan ini adalah fungsi untuk READ (lihat detail)
public function showMatakuliah($kode_mk) {
   $matakuliah = \App\Models\Matakuliah::with('dosen')->where('kode_mk', $kode_mk)->firstOrFail();
    return response()->json($matakuliah); // PENTING: Harus json()
}

// Pastikan ini adalah fungsi untuk EDIT (ambil data ke form)
public function editMatakuliah($kode_mk) {
   $matakuliah = \App\Models\Matakuliah::with('dosen')->where('kode_mk', $kode_mk)->firstOrFail();
    return response()->json($matakuliah); // PENTING: Harus json()
}

public function updateMatakuliah(Request $request, $kode_mk) {
    $matakuliah = \App\Models\Matakuliah::where('kode_mk', $kode_mk)->firstOrFail();
    $matakuliah->update([
        'nama_mk'  => $request->nama_mk,
        'sks'      => $request->sks,
        'semester' => $request->semester,
        'dosen_id' => $request->dosen_id,// Menyimpan ID dosen yang dipilih
    ]);
    return redirect()->back()->with('success', 'Berhasil diperbarui!');
}

public function destroy($id) {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}