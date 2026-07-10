<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Mahasiswa | Si Pekas Polibatam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2d9d6c5f8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>
    body { background-color: #f8faff; font-family: 'Poppins', sans-serif; }
    .sidebar { height: 100vh; width: 260px; background-color: #0f172a; padding-top: 20px; position: fixed; z-index: 1000; }
    .sidebar-brand { display: flex; align-items: center; padding: 0 20px; margin-bottom: 30px; }
    .brand-logo { width: 45px; height: 45px; background-color: #1e293b; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-right: 12px; overflow: hidden; }
    .brand-text h6 { margin: 0; font-weight: 800; color: #ffffff; font-size: 16px; }
    .brand-text span { font-size: 13px; color: #94a3b8; }
    .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: 12px 20px; border-radius: 10px; margin: 5px 15px; transition: 0.3s; }
    .sidebar a.active { background-color: #3b82f6; color: #fff; font-weight: 600; }
    .sidebar a:hover:not(.active) { background-color: #1e293b; color: #3b82f6; }
    .content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); }
    .card-stat { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: #fff; }
    section { display: none; }
    section.active-section { display: block; animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .profile-section { display: flex; align-items: center; background: #fff; padding: 8px 15px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .profile-avatar { width: 40px; height: 40px; background-color: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; margin-right: 12px; text-transform: uppercase; }
    .profile-info .name { font-size: 14px; font-weight: bold; margin: 0; }
    .profile-info .nim { font-size: 12px; color: #777; margin: 0; }
  </style>
</head>
<body>

<div class="d-flex">
  <div class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-logo"><img src="data:image/png;base64,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" alt="Logo" style="width: 80%; height: 80%; object-fit: contain;"></div>
      <div class="brand-text"><h6>Si Pekas Polibatam</h6><span>Dashboard Mahasiswa</span></div>
    </div>
    <a href="javascript:void(0)" class="nav-link-custom active" data-target="dashboard"><i class="fas fa-home me-2"></i> Dashboard</a>
    <a href="javascript:void(0)" class="nav-link-custom" data-target="krs"><i class="fas fa-edit me-2"></i> Pengambilan KRS</a>
    <a href="javascript:void(0)" class="nav-link-custom" data-target="khs"><i class="fas fa-file-invoice me-2"></i> Lihat KHS</a>
    <hr class="mx-3 border-secondary">
<a href="#" class="text-warning" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt me-2"></i> Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
  </div>

  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div><h4 class="fw-bold">Dashboard Mahasiswa</h4><p class="text-muted">
            Selamat Datang, <strong>{{ $user->name }}</strong> (NIM: {{ $user->identity_number }})
       🙌 </p>
    </div>
      <div class="profile-section">
        <div class="profile-avatar" id="profile-initial">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
<div class="profile-info">
        <p class="name">{{ $user->name }}</p>
        <p class="nim">{{ $user->identity_number }}</p>
    </div>
      </div>
    </div>

    <section id="dashboard" class="active-section">
 <div class="card">
    <p>IP</p>
    <h3>{{ number_format($ip, 2) }}</h3>
</div>

<div class="card">
    <div class="card-body">
        <p>MAKSIMAL SKS</p>
        <h3>{{ $maxSks }} SKS</h3>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p>SKS TERPILIH (KRS)</p>
        <h3>{{ $sksTerpilih }} SKS</h3>
    </div>
</div>
    </section>

   <section id="krs">
    <div class="mt-5">
    <h5>Status Pengajuan KRS</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Kode MK</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- Pastikan variabel $dataKrs sudah dikirim dari controller --}}
            @forelse($dataKrs as $item)
            <tr>
                <td>{{ $item->kode_mk }}</td>
               <td>
    @if($item->status == 'pending')
        <span class="badge" style="background-color: yellow; color: black; padding: 5px 10px; border-radius: 5px;">
            Pending
        </span>
    @elseif($item->status == 'disetujui')
        <span class="badge" style="background-color: blue; color: white; padding: 5px 10px; border-radius: 5px;">
            disetujui
        </span>
    @elseif($item->status == 'Ditolak')
        <span class="badge" style="background-color: red; color: white; padding: 5px 10px; border-radius: 5px;">
            Ditolak
        </span>
    @else
        {{ $item->status }}
    @endif
</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">Belum ada KRS yang diajukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <div class="card card-stat p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Pengambilan KRS</h4> <div class="d-flex align-items-center">
                <label class="me-2 small fw-bold">Semester:</label>
                <form method="GET" action="{{ route('dashboard_mahasiswa') }}" id="form-semester">
                    <select name="semester" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('semester', 1) == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
          
      <!-- Pastikan ID-nya adalah 'total-sks' -->
       <form action="{{ route('krs.simpan') }}" method="POST">
    @csrf
<div class="alert alert-info py-2 small border-0">Total SKS Terpilih: <span id="total-sks-display">0</span> / 20 SKS</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr><th>Pilih</th><th>Kode</th><th>Mata Kuliah</th><th class="text-center">SKS</th><th>Dosen Pengampu</th></tr>
            </thead>
            <!-- Ubah bagian ini di dalam file Blade Anda -->
<tbody id="krs-table">
  @forelse($daftarKelas as $mk)
        <tr>
            <td>
              <input type="checkbox" name="matakuliah_ids[]" value="{{ $mk->kode_mk }}" class="krs-checkbox"data-sks="{{ $mk->sks }}">
            </td>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>{{ $mk->dosen ? $mk->dosen->name : 'Belum ada dosen' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada mata kuliah untuk semester ini.</td>
        </tr>
    @endforelse
</tbody>
          </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
         <!-- KODE BARU (Gunakan ini) -->
<a href="{{ route('krs.export') }}" class="btn btn-outline-secondary me-2">
    <i class="fas fa-file-pdf me-2"></i>Export KRS
</a>
          <button class="btn btn-primary px-4" onclick="saveKRS()">Simpan KRS</button>
        </div>
      </div>
    </section>

    <section id="khs">
      <div class="card card-stat p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold"><i class="fas fa-graduation-cap me-2"></i>Kartu Hasil Studi (KHS)</h5>
<a href="{{ route('mahasiswa.export.khs') }}" class="btn btn-primary">Export KHS</a>
        </div>
        <table class="table table-bordered align-middle text-center">
          <thead class="table-light">
            <tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai Akhir</th></tr>
          </thead>
      <tbody>
    @forelse($dataKHS as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        {{-- Langsung akses matakuliah dari objek $item (Krs) --}}
        <td>{{ $item->matakuliah->kode_mk ?? '-' }}</td>
        <td>{{ $item->matakuliah->nama_mk ?? '-' }}</td>
        <td>{{ $item->matakuliah->sks ?? '-' }}</td>
        <td>{{ $item->nilai ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center">Belum ada nilai KHS yang tersedia.</td>
    </tr>
    @endforelse
</tbody>
    </table>
  </div>
</section>

<script>
function hitungTotalSKS() {
    let totalSKS = 0;
    
    // Cari semua checkbox yang dicentang
    const checkboxes = document.querySelectorAll('.krs-checkbox:checked');
    
    checkboxes.forEach((cb) => {
        // Ambil nilai dari data-sks
        totalSKS += parseInt(cb.getAttribute('data-sks'));
    });

    // Sesuaikan ID dengan yang ada di HTML (total-sks-display)
    document.getElementById('total-sks-display').innerText = totalSKS;

    // Peringatan jika melebihi batas 20 SKS (sesuai tampilan Anda)
    if (totalSKS > 20) {
        alert("Peringatan: Total SKS Anda melebihi batas maksimal (20 SKS)!");
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.krs-checkbox');
    
    checkboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            hitungTotalSKS();
        });
    });
});
  function generateInitial() {
    const name = document.getElementById('user-fullname').innerText;
    const words = name.split(' ');
    document.getElementById('profile-initial').innerText = words.length > 1 ? words[0][0] + words[1][0] : words[0][0];
  }
  window.onload = generateInitial;

  const links = document.querySelectorAll('.nav-link-custom');
  const sections = document.querySelectorAll('section');
  links.forEach(link => {
    link.addEventListener('click', function() {
      links.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
      sections.forEach(s => s.classList.remove('active-section'));
      document.getElementById(this.getAttribute('data-target')).classList.add('active-section');
    });
  });

  function confirmLogout(event) {
      event.preventDefault(); 
      if (confirm("Apakah Anda yakin ingin keluar?")) {
          document.getElementById('logout-form').submit(); 
      }
    }

    
  function exportPDF(type) { alert(`Fungsi ekspor ${type} akan diimplementasikan setelah database terhubung.`); }
  function saveKRS() { alert("Krs berhasil disimpan!"); }
</script>
</body>
</html>