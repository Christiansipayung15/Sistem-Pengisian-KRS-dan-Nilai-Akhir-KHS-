<!DOCTYPE html>
<html lang="id">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dosen - Sistem KRS & KHS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
    .hover-effect:hover { background-color: #f1f5f9; transform: translateY(-5px); transition: 0.3s; }
    .sidebar { height: 100vh; width: 260px; background-color: #0f172a; position: fixed; top: 0; left: 0; padding: 1.5rem 1rem; color: white; z-index: 1000; }
    .sidebar .brand { display: flex; align-items: center; margin-bottom: 2rem; padding-left: 0.5rem; }
    .sidebar .brand img { width: 45px; height: 45px; border-radius: 8px; margin-right: 12px; object-fit: cover; }
    .sidebar .brand-text { display: flex; flex-direction: column; }
    .sidebar .brand-title { font-weight: 700; font-size: 1.1rem; color: white; line-height: 1.2; }
    .sidebar .brand-subtitle { font-size: 0.85rem; color: #94a3b8; }
    .sidebar .nav-link { color: #cbd5e1; border-radius: 10px; padding: 12px 15px; margin-bottom: 8px; transition: 0.3s; text-decoration: none; display: block; cursor: pointer; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #3b82f6; }
    .content { margin-left: 260px; padding: 2rem; }
    .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
    section { display: none; }
    section.active-section { display: block; animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .table-hover tbody tr:hover { background-color: #f1f5f9; }
    /* Container utama profil (lonjong putih) */
.profile-section {
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 8px 15px;
    border-radius: 50px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    width: fit-content;
}

/* Bulatan biru untuk inisial */
.profile-avatar {
    width: 40px;
    height: 40px;
    background-color: #3b82f6; /* Warna biru */
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%; /* Membuat lingkaran */
    font-weight: bold;
    margin-right: 12px;
}

/* Info Nama dan NIM */
.profile-info .name { font-size: 14px; font-weight: bold; margin: 0; }
.profile-info .nim { font-size: 12px; color: #777; margin: 0; }
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="brand">
      <img src="data:image/png;base64,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" alt="Logo">
      <div class="brand-text">
        <span class="brand-title">Si Pekas Polibatam</span>
        <span class="brand-subtitle">Dashboard Dosen</span>
      </div>
    </div>
    <nav class="nav flex-column">
      <a class="nav-link active" data-target="dashboard"><i class="bi bi-grid me-2"></i> Dashboard</a>
      <a class="nav-link" data-target="matkul-ampu"><i class="bi bi-book me-2"></i> Matakuliah Diampu</a>
      <a class="nav-link" data-target="input-nilai"><i class="bi bi-pencil-square me-2"></i> Input Nilai Akhir</a>
      @if(auth()->user()->tipe_dosen == 'wali')
        <a href="{{ route('dosen.wali.dashboard') }}" class="nav-link">
            Login sebagai dosen wali
        </a>
    @endif
      <hr class="border-secondary">
      
      <a href="{{ route('logout') }}" class="nav-link text-warning" onclick="confirmLogout(event)">
        <i class="bi bi-box-arrow-right me-2"></i> Keluar
      </a>
      
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </nav>
  </div>

  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
      <h4 class="fw-bold">Dashboard Dosen</h4><p class="text-muted">
            Selamat Datang, <strong>{{ $user->name }}</strong> (NIP: {{ $user->identity_number }})
       🙌 </p>
    </div>
     <div class="profile-section">
    <!-- Inisial otomatis akan tampil di dalam lingkaran -->
    <div class="profile-avatar" id="profile-initial">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    
    <div class="profile-info">
        <p class="name mb-0 fw-bold">{{ $user->name }}</p>
        <p class="nim mb-0 text-muted small">{{ $user->identity_number }}</p>
    </div>
</div>
    </div>

    <section id="dashboard" class="active-section">
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card card-custom p-4 border-start border-primary border-4 text-center">
        <h6 class="text-muted small">Mata Kuliah Diampu</h6>
        <h2 class="fw-bold">{{ $jumlahMatkul }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 border-start border-success border-4 text-center">
        <h6 class="text-muted small">Total Mahasiswa</h6>
        <h2 class="fw-bold">{{ $totalMahasiswa }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 border-start border-warning border-4 text-center">
        <h6 class="text-muted small">Progress Input Nilai</h6>
        <h2 class="fw-bold">{{ $progressNilai }}%</h2> </div>
    </div>
  </div>
</section>

   <section id="matkul-ampu">
  <h5 class="fw-bold mb-3">Daftar Mata Kuliah yang Anda Ampu</h5>
  
<div class="row g-3" id="matkul-list">
      @forelse($mataKuliah as $mk)
        <div class="col-md-4">
          <a href="{{ route('dosen.matakuliah.detail', $mk->kode_mk) }}" class="text-decoration-none">
            <div class="card card-custom p-3 h-100 shadow-sm hover-effect">
                <h6 class="fw-bold text-primary">{{ $mk->nama_mk }}</h6>
                <p class="mb-1 small text-muted">Kode: {{ $mk->kode_mk }}</p>
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="badge bg-light text-dark">{{ $mk->sks }} SKS</span>
                  <span class="badge bg-light text-dark">Semester {{ $mk->semester }}</span>
                </div>
            </div>
          </a>
        </div>
      @empty
        <p>Anda belum mengampu mata kuliah apapun.</p>
      @endforelse
      
  </div>
</section>
  <!-- SELESAI -->
  


   <section id="input-nilai">
    <div class="card card-custom p-4">
        <form action="{{ route('dosen.simpanNilai') }}" method="POST">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0">Input Nilai</h5>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="backToMatkul()">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Simpan Nilai</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mata Kuliah</th> 
                            <th style="width: 200px;">Nilai Akhir (A-E)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="student-list">
                        @forelse($dataMahasiswa as $item)
                        <tr>
                            <td>{{ $item->mahasiswa->identity_number ?? '-' }}</td>
                            <td>{{ $item->mahasiswa->name ?? '-' }}</td>
                            <td>{{ $item->matakuliah->nama_mk ?? '-' }}</td>
                            <td>
                                {{-- Gunakan array name agar bisa diproses di controller --}}
                                <select name="nilai[{{ $item->id }}]" class="form-select">
                                    
                                    <option value="A" {{ $item->nilai == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ $item->nilai == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ $item->nilai == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ $item->nilai == 'D' ? 'selected' : '' }}>D</option>
                                    <option value="E" {{ $item->nilai == 'E' ? 'selected' : '' }}>E</option>
                                </select>
                            </td>
                            <td>
                                @if(!empty($item->nilai))
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                @else
                                    <span class="badge bg-danger">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Aksi Anda tetap di sini --><td>
                  <button type="button" class="btn btn-sm btn-outline-primary" 
    onclick="showDetail(
        '{{ $item->mahasiswa->identity_number ?? '' }}', 
        '{{ $item->mahasiswa->name ?? '' }}', 
        '{{ !empty($item->nilai) ? 'Sudah Dinilai' : 'Belum Dinilai' }}', 
        '{{ $item->matakuliah->nama_mk ?? '' }}',
        event  // <--- Tambahkan kata 'event' di sini
    )">
    <i class="bi bi-eye"></i>
</button>
<button class="btn btn-sm btn-outline-info" onclick="showEdit('{{ $item->id }}', event)">
    <i class="bi bi-pencil"></i>
</button>

<a href="{{ route('dosen.krs.reset', $item->id) }}" 
   class="btn btn-sm btn-outline-danger" 
   onclick="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')">
   <i class="bi bi-trash"></i>
    </button>
</form>                    
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</section>





    <div class="modal fade" id="actionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Aksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                </div>
        </div>
    </div>
</div>

  <script>
    const links = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section');

    links.forEach(link => {
      link.addEventListener('click', function() {
        if(this.dataset.target) {
          links.forEach(l => l.classList.remove('active'));
          this.classList.add('active');
          sections.forEach(s => s.classList.remove('active-section'));
          document.getElementById(this.dataset.target).classList.add('active-section');
        }
      });
    });

    function backToMatkul() {
      document.querySelector('[data-target="matkul-ampu"]').click();
    }

    

    // Fungsi konfirmasi logout yang memicu submit form POST
    function confirmLogout(event) {
      event.preventDefault(); 
      if (confirm("Apakah Anda yakin ingin keluar?")) {
          document.getElementById('logout-form').submit(); 
      }
    }
function showDetail(nim, nama, status, matakuliah,event) { // Tambahkan parameter matakuliah
    document.getElementById('modalTitle').innerText = "Detail Mahasiswa";
    
    document.getElementById('modalBody').innerHTML = `
        <p><strong>NIM:</strong> ${nim}</p>
        <p><strong>Nama:</strong> ${nama}</p>
        <p><strong>Mata Kuliah:</strong> ${matakuliah}</p> <!-- Tambahkan baris ini -->
        <p><strong>Status:</strong> ${status}</p>
    `;
    
    new bootstrap.Modal(document.getElementById('actionModal')).show();
}

// Di file blade Anda, pada bagian <script>
function showEdit(id, event) {
    // 1. Mencegah navigasi bawaan (seperti href="#" yang sering bikin halaman refresh)
    if (event) {
        event.preventDefault();
        event.stopPropagation(); // Mencegah klik menyebar ke sidebar/navigasi
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    document.getElementById('modalTitle').innerText = "Edit Nilai";
    
    document.getElementById('modalBody').innerHTML = `
        <form action="/dosen/simpan-nilai/${id}" method="POST">
            <input type="hidden" name="_token" value="${token}">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-3">
                <label>Pilih Nilai Baru:</label>
                <select name="nilai_baru" class="form-select" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan Nilai</button>
        </form>
    `;
    
    // Menampilkan modal Bootstrap
    var myModal = new bootstrap.Modal(document.getElementById('actionModal'));
    myModal.show();
}
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>