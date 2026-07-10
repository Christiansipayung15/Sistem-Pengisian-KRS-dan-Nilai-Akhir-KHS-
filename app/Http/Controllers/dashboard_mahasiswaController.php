<?php


namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KHS;
use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\KelasAmpu; // Pastikan import model ini!

class dashboard_mahasiswaController extends Controller

{
// Contoh di dalam Controller
public function lihatKhs()
{
    // Menggunakan 'with' untuk mengambil data dosen sekaligus
    $krs = Krs::with('dosen')->where('mahasiswa_id', auth()->user()->id)->get();
    
    return view('mahasiswa.khs', compact('krs'));
}
public function dashboard() {
    $user = auth()->user();
    $dataKHS = Nilai::where('user_id', $user->id)->get(); // Sesuaikan model Anda

    $totalBobot = 0;
    $totalSks = 0;

    foreach ($dataKHS as $item) {
        $nilaiAngka = $this->konversiNilai($item->nilai); // Fungsi bantu di bawah
        $sks = $item->matakuliah->sks;
        
        $totalBobot += ($nilaiAngka * $sks);
        $totalSks += $sks;
    }

    $ipk = ($totalSks > 0) ? ($totalBobot / $totalSks) : 0;

    return view('dashboard_mahasiswa', compact('ipk', 'dataKHS'));
}

// Fungsi bantu untuk konversi huruf ke angka
private function konversiNilai($huruf) {
    $map = [
        'A'  => 4, 
        'AB' => 3.5, 
        'B'  => 3, 
        'BC' => 2.5, 
        'C'  => 2, 
        'D'  => 1, 
        'E'  => 0
    ];
    return $map[strtoupper($huruf)] ?? 0;
}
public function dashboard_mahasiswa() {
    $user = auth()->user();
    $dataKHS = Nilai::where('user_id', $user->id)->get();

    $totalBobot = 0;
    $totalSks = 0;

    foreach ($dataKHS as $item) {
        // Pastikan fungsi konversiNilai sudah ada di dalam controller ini
        $nilaiAngka = $this->konversiNilai($item->nilai); 
        $sks = $item->matakuliah->sks ?? 0; // Menggunakan null coalescing untuk keamanan
        
        $totalBobot += ($nilaiAngka * $sks);
        $totalSks += $sks;
    }

    $ipk = ($totalSks > 0) ? ($totalBobot / $totalSks) : 0;

    // Kirim data ke view dengan array asosiatif
    return view('dashboard_mahasiswa', [
        'user'        => $user,
        'dataKHS'     => $dataKHS,
        'ipk'         => $ipk, 
        // Tambahkan variabel lain yang dibutuhkan view Anda di sini
        'maxSks'      => $maxSks ?? 20, 
        'sksTerpilih' => $sksTerpilih ?? 0,
        'daftarKelas' => $daftarKelas ?? [],
        'dataKrs'     => $dataKrs ?? []
    ]);
}
 public function simpanKrs(Request $request) 
{
    $request->validate([
        'matakuliah_ids' => 'required|array',
    ]);

    foreach ($request->matakuliah_ids as $mkId) {
        // Cari data matakuliah untuk mendapatkan dosen_id
        $matakuliah = \App\Models\MataKuliah::where('kode_mk', $mkId)->first();

        \App\Models\Krs::create([
            'mahasiswa_id' => auth()->id(), 
            'kode_mk'      => $mkId,
            'semester'     => '1', 
            'status'       => 'Pending',
            // AMBIL dosen_id DARI TABEL MATA KULIAH
            'dosen_id'     => $matakuliah ? $matakuliah->dosen_id : null, 
        ]);
    }

    return redirect()->route('dashboard_mahasiswa')
                     ->with('success', 'KRS berhasil disimpan!');
}
public function exportPdf()
{
    $user = auth()->user(); // Memastikan data user (termasuk nim) terambil
    $dataKHS = \App\Models\Krs::where('mahasiswa_id', $user->id)->get();

    $map = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];
    
    $totalSks = 0;
    $totalKxN = 0;

    foreach ($dataKHS as $item) {
        $sks = $item->matakuliah->sks ?? 0; // Tambahkan ?? 0 untuk jaga-jaga jika relasi null
        $nilaiAngka = $map[$item->nilai] ?? 0;
        
        $totalSks += $sks;
        $totalKxN += ($sks * $nilaiAngka);
    }

    $ips = $totalSks > 0 ? ($totalKxN / $totalSks) : 0;
    $ipk = $ips; 

    // Tidak ada perubahan di bagian ini, karena $user sudah dikirim
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.khs', compact('dataKHS', 'user', 'totalSks', 'totalKxN', 'ips', 'ipk'));
    return $pdf->download('KHS_'.$user->name.'.pdf');
}
  public function exportKrsPdf(Request $request)
{
    $user = auth()->user();
    // 1. Pastikan variabel $semester sudah ada. 
    // Jika tidak ada di request, gunakan default 1.
    $semester = $request->query('semester', 1);

    // Pastikan menggunakan 'with' untuk memuat relasi
$krsData = \App\Models\Krs::where('mahasiswa_id', $user->id)
                ->where('semester', $semester)
                ->with(['matakuliah', 'dosen'])
                ->get();
    $totalSks = $krsData->sum(function($item) {
        return $item->matakuliah ? $item->matakuliah->sks : 0;
    });

$pdf = \PDF::loadView('dosen.krs.pdf', compact('user', 'krsData', 'semester', 'totalSks'));
    
    return $pdf->download('KRS_' . $user->name . '.pdf');
}

public function index(Request $request)
{
    $mahasiswa_id = auth()->id();
    $user = auth()->user();

    // 1. Data KRS Mahasiswa
    $dataKrs = \App\Models\Krs::where('mahasiswa_id', $user->id)
                                ->with(['matakuliah', 'dosen'])
                                ->get();

    // 2. Data IPK Lalu & SKS
    $ipkLalu = KHS::where('mahasiswa_id', $user->id)->avg('nilai_angka') ?? 0;
    $maxSks = ($ipkLalu >= 3.0) ? 24 : 20;
    
    $sksTerpilih = \App\Models\Krs::where('mahasiswa_id', $user->id)
                    ->join('mata_kuliah', 'krs.kode_mk', '=', 'mata_kuliah.kode_mk')
                    ->sum('sks');

    // 3. Query data KRS yang "Sudah Dinilai"
    $dataKHS = \App\Models\Krs::where('mahasiswa_id', $mahasiswa_id)
                              ->where('status', 'Sudah Dinilai')
                              ->with('matakuliah')
                              ->get();

    // 4. LOGIKA PERHITUNGAN IP
    $bobotMap = ['A' => 4, 'AB' => 3.5, 'B' => 3, 'BC' => 2.5, 'C' => 2, 'D' => 1, 'E' => 0];
    $totalSks = 0;
    $totalNilai = 0;

    foreach ($dataKHS as $item) {
        $sks = $item->matakuliah->sks ?? 0;
        // Pastikan kolom 'nilai' di tabel 'krs' berisi huruf (A, B, C, dst)
        $bobot = $bobotMap[strtoupper($item->nilai)] ?? 0;
        
        $totalSks += $sks;
        $totalNilai += ($bobot * $sks);
    }

    $ip = ($totalSks > 0) ? ($totalNilai / $totalSks) : 0;

    // 5. Data Semester & Kelas
    $semester = $request->input('semester', 1);
    $daftarKelas = \App\Models\MataKuliah::with('dosen')->where('semester', $semester)->get();

    // 6. Mengirim data ke view
    return view('dashboard_mahasiswa', compact(
        'daftarKelas', 
        'semester', 
        'user', 
        'ipkLalu', 
        'maxSks', 
        'sksTerpilih',
        'dataKrs',
        'dataKHS',
        'ip'
    ));
}
}