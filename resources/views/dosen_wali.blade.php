<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen Wali - Si Pekas Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .sidebar { height: 100vh; width: 260px; background-color: #0f172a; position: fixed; top: 0; left: 0; padding: 1.5rem 1rem; color: white; }
        .nav-link { color: #cbd5e1; border-radius: 10px; padding: 12px 15px; margin-bottom: 8px; display: block; text-decoration: none; cursor: pointer; }
        .nav-link:hover, .nav-link.active { background-color: #1e293b; color: #3b82f6; }
        .content { margin-left: 260px; padding: 2rem; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
        section { display: none; }
        section.active-section { display: block; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand mb-4 px-2">
            <span class="fw-bold text-white">Si Pekas - Dosen Wali</span>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" data-target="dashboard-wali"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a class="nav-link" data-target="krs-wali"><i class="bi bi-check-circle me-2"></i> Persetujuan KRS</a>
            <a class="nav-link" data-target="khs-wali"><i class="bi bi-file-earmark-text me-2"></i> Data KHS</a>
            <hr class="border-secondary">
 
        </nav>
    </div>

   <div class="content">
    <h4 class="fw-bold mb-4">Dashboard Dosen Wali</h4>

    <section id="dashboard-wali" class="active-section">
        <div class="row mb-4">
            <div class="col-md-4">
    <div class="card bg-secondary text-white p-3 shadow-sm">
        <h5>Menunggu</h5>
        <h3 id="count-menunggu">{{ $jumlahMenunggu }}</h3>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-success text-white p-3 shadow-sm">
        <h5>Disetujui</h5>
        <h3 id="count-disetujui">{{ $jumlahDisetujui }}</h3>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-danger text-white p-3 shadow-sm">
        <h5>Ditolak</h5>
        <h3 id="count-ditolak">{{ $jumlahDitolak }}</h3>
    </div>
</div>
        </div>

        <div class="card card-custom p-4">
            <h5>Selamat Datang di Portal Dosen Wali</h5>
        </div>
    </section>


    <section id="krs-wali">
    <div class="card card-custom p-4">
        <h5 class="fw-bold mb-3">Persetujuan KRS Mahasiswa</h5>


<div class="mb-3">
    <label for="filterKelas">Pilih Kelas:</label>
    <select id="filterKelas" class="form-control" onchange="filterData()">
        <option value="">Semua Kelas</option>
        <option value="A">A</option> <option value="B">B</option>
        <option value="C">C</option>
    </select>
</div>


        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th> <th>Mata Kuliah</th>
                        <th>Total SKS</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
     <tbody>
    @foreach($pengajuanKRS as $pengajuan)
    <tr>
        {{-- Mengambil NIM dari identity_number di tabel users via relasi --}}
        <tr class="row-krs" data-kelas="{{ $pengajuan->mahasiswa->kelas ?? '' }}">
       <td>{{ $pengajuan->mahasiswa->identity_number ?? '-' }}</td>
                    <td>{{ $pengajuan->mahasiswa->name ?? '-' }}</td>
                    <td>{{ $pengajuan->mahasiswa->kelas ?? '-' }}</td> {{-- Menampilkan kelas --}}
                    <td>{{ $pengajuan->matakuliah->nama_mk ?? '-' }}</td>
                    <td>{{ $pengajuan->matakuliah->sks ?? '0' }} SKS</td>
        
        {{-- Status --}}
        <td>
            @if($pengajuan->status == 'Menunggu')
                <span class="badge bg-warning">Menunggu</span>
            @elseif($pengajuan->status == 'Disetujui')
                <span class="badge bg-success">Disetujui</span>
            @else
                <span class="badge bg-danger">{{ $pengajuan->status }}</span>
            @endif
        </td>
        
        {{-- Tombol Aksi --}}
        <td>
            <div class="d-flex gap-2">
                <form action="{{ route('krs.acc', $pengajuan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Disetujui</button>
                </form>
                <form action="{{ route('krs.tolak', $pengajuan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Ditolak</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</section>

        <section id="khs-wali">
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-3">Data KHS Mahasiswa</h5>
             <table class="table">
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>IPS</th>
            <th>IPK</th>
        </tr>
    </thead>
    <tbody>
      @foreach($mahasiswas as $mhs)
    <tr>
        <td>{{ $mhs->identity_number }}</td>
        <td>{{ $mhs->name }}</td>
        <td>{{ number_format($mhs->ips, 2) }}</td>
        <td>{{ number_format($mhs->ipk, 2) }}</td>
    </tr>
@endforeach
    </tbody>
</table>
            </div>
        </section>
    </div>

    <script>
        function loadDataKelas() {
    let kelas = $('#pilih-kelas').val(); // Mengambil kelas dari dropdown

    $.ajax({
        url: "{{ route('get.statistik.kelas') }}", // Pastikan route ini ada
        method: 'GET',
        data: { kelas: kelas },
        success: function(response) {
            // Update angka kartu statistik
            $('#count-menunggu').text(response.menunggu);
            $('#count-disetujui').text(response.disetujui);
            $('#count-ditolak').text(response.ditolak);
            
            // Update tabel di sini (opsional)
        },
        error: function() {
            alert('Gagal mengambil data statistik.');
        }
    });
}
     function filterData() {
    // 1. Ambil nilai kelas yang dipilih dari dropdown
    var selectedKelas = document.getElementById('filterKelas').value;
    
    // 2. Ambil semua baris tabel yang memiliki class 'row-krs'
    var rows = document.querySelectorAll('.row-krs');

    rows.forEach(function(row) {
        // 3. Ambil data kelas dari atribut 'data-kelas' di setiap baris
        var kelasMhs = row.getAttribute('data-kelas');
        
        // 4. Jika 'Semua Kelas' dipilih atau kelas cocok, tampilkan baris tersebut
        if (selectedKelas === "" || kelasMhs === selectedKelas) {
            row.style.display = ""; 
        } else {
            row.style.display = "none"; // Sembunyikan baris
        }
    });
}   // Script untuk pindah menu (sama dengan kode Anda)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if(this.dataset.target) {
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    document.querySelectorAll('section').forEach(s => s.classList.remove('active-section'));
                    document.getElementById(this.dataset.target).classList.add('active-section');
                }
            });
        });
    </script>
</body>
</html>