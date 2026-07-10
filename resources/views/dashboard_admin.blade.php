<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin | Si Pekas Polibatam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    :root { --sidebar-bg: #0f172a; --accent-blue: #3b82f6; --text-gray: #94a3b8; }
    body { background-color: #f1f5f9; font-family: 'Segoe UI', sans-serif; }
    .sidebar { height: 100vh; width: 260px; background-color: var(--sidebar-bg); position: fixed; color: #fff; z-index: 1000; padding-top: 20px; }
    .brand-section { padding: 0 20px 30px 20px; }
    .sidebar a { color: var(--text-gray); text-decoration: none; display: flex; align-items: center; padding: 12px 20px; border-radius: 8px; margin: 5px 15px; transition: 0.3s; }
    .sidebar a.active, .sidebar a:hover { background-color: #1e293b; color: #fff; }
    .content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); }
    .card-custom { border-radius: 12px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: #fff; }
    section { display: none; }
    section.active-section { display: block; }
    .modal-lg-custom { max-width: 600px; }
    .modal-content-custom { padding: 30px; border-radius: 15px; }
  </style>
</head>
<body>

<div class="sidebar d-flex flex-column vh-100 bg-dark text-white" style="width: 250px;">
    <div class="brand-section p-3 border-bottom border-secondary">
        <div class="d-flex align-items-center">
            <img src="data:image/png;base64,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" alt="Logo" width="40" height="40" class="me-2 rounded shadow-sm">
            <div class="lh-1">
                <h1 class="h6 m-0 fw-bold">Si Pekas Polibatam</h1>
                <p class="small text-white-50 m-0">Dashboard Admin</p>
            </div>
        </div>
    </div>
    <nav>
      <a href="#" class="nav-link-admin active" data-target="dash"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
      <a href="#" class="nav-link-admin" data-target="data-matkul"><i class="bi bi-journal-bookmark-fill me-2"></i> Kelola Matakuliah</a>
      <a href="#" class="nav-link-admin" data-target="data-pengguna"><i class="bi bi-people-fill me-2"></i> Kelola Pengguna</a>
      <a href="#" class="nav-link-admin" data-target="data-kelas"><i class="bi bi-person-badge me-2"></i> Data Kelas Dosen Wali</a>
      <hr class="mx-3 border-secondary">
      <a href="#" class="text-warning" onclick="confirmLogout()">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </a>
    </nav>
  </div>

  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div><h4 class="fw-bold">Dashboard Admin</h4><p class="text-muted small">Otoritas penuh pengelolaan data sistem KRS & KHS</p></div>
      <span class="badge bg-dark px-3 py-2">Role: Admin</span>
    </div>

    <section id="dash" class="active-section">
      <div class="row g-3">
    <div class="col-md-4">
        <div class="card card-custom p-4 border-start border-primary border-5">
            <h6>TOTAL MAHASISWA</h6>
            <h3>{{ $totalMahasiswa }}</h3>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-custom p-4 border-start border-success border-5">
            <h6>TOTAL DOSEN</h6>
            <h3>{{ $totalDosen }}</h3>
        </div>
    </div>
    
    <div class="col-md-4">
    <div class="card card-custom p-4 border-start border-warning border-5">
        <h6>TOTAL MATAKULIAH</h6>
        <h3>{{ $totalMatkul }}</h3>
    </div>
</div>
    </section>

    <section id="data-matkul">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Kelola Mata Kuliah</h5>
       <input type="text" id="searchMatkul" class="form-control w-25" placeholder="Cari Matakuliah...">
      </div>
      <form action="{{ route('matakuliah.store') }}" method="POST" class="card card-custom p-4 mb-4">
    @csrf
    <div class="row g-3">
        <div class="col-md-2">
            <input type="text" name="kode_mk" class="form-control" placeholder="Kode MK" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="nama_mk" class="form-control" placeholder="Nama Mata Kuliah" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="sks" class="form-control" placeholder="SKS" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="semester" class="form-control" placeholder="Semester" required>
        </div>
        <div class="col-md-3">
            <select name="dosen_id" class="form-select" required>
                <option value="">Pilih Dosen</option>
                @foreach($all_dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Tambah</button>
        </div>
    </div>
</form>
 <table class="table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Dosen Pengampu</th>
            <th>Aksi</th> </tr>
    </thead>
    <tbody>
        @foreach($matakuliahs as $mk)
        <tr>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>{{ $mk->semester }}</td>
            <td>{{ $mk->dosen ? $mk->dosen->name : 'Belum Ada' }}</td>
            <td>
                <button class="btn btn-sm btn-outline-info" onclick="loadReadMatkul('{{ $mk->kode_mk }}')">
    <i class="bi bi-eye"></i>
</button>
<button class="btn btn-sm btn-outline-primary" onclick="loadEditMatkul('{{ $mk->kode_mk }}')">
    <i class="bi bi-pencil"></i>
</button>
                
                <form action="{{ route('matakuliah.destroy', $mk->kode_mk) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</section>

   <section id="data-pengguna" class="active-section">
    <h5>Kelola Pengguna</h5>
<input type="text" id="searchUser" class="form-control mb-3" placeholder="Cari Nama Pengguna...">  

    

    <form action="/tambah-pengguna" method="POST" class="card p-3 mb-4">
        @csrf
        <div class="row g-2">
            <div class="col"><input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required></div>
            <div class="col"><input type="text" name="identity_number" class="form-control" placeholder="ID/NIM" required></div>
            <div class="col">
                <select name="role" class="form-select">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>
            <div class="col"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
            <div class="col"><button type="submit" class="btn btn-success">Tambah</button></div>
        </div>
    </form>

    <div class="card p-4">
        <table class="table">
            <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Peran</th>
            <th>Peran Dosen</th><th>Kelas</th> <!-- Pindahkan ini sebelum Aksi -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->role }}</td>
            
            <!-- Kolom Peran Dosen -->
            <!-- Kolom Peran Dosen -->
           <td>
           @if($user->role == 'dosen')
        <div class="input-group input-group-sm">
            <select class="form-select" id="tipe-{{ $user->id }}">
                <option value="">Pilih peran Dosen</option>
                <option value="wali" {{ $user->tipe_dosen == 'wali' ? 'selected' : '' }}>Dosen Wali</option>
                <option value="matkul" {{ $user->tipe_dosen == 'matkul' ? 'selected' : '' }}>Dosen Matkul</option>
            </select>
            
            <button class="btn btn-primary" onclick="simpanTipe({{ $user->id }})">Simpan</button>
        </div>
    @endif
</td>

       <!-- Di dalam kolom Kelas -->
<!-- GANTI BLOK KODE KOLOM KELAS ANDA DENGAN INI -->
<td>
    @if($user->role == 'mahasiswa')
        <!-- Dropdown Kelas khusus untuk Mahasiswa -->
        <div class="input-group input-group-sm">
            <select class="form-select" id="kelas-{{ $user->id }}">
                <option value="">Pilih Kelas</option>
                <option value="A" {{ $user->kelas == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ $user->kelas == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ $user->kelas == 'C' ? 'selected' : '' }}>C</option>
            </select>
            <button class="btn btn-primary" onclick="simpanKelas({{ $user->id }})">Simpan</button>
        </div>

    @elseif($user->role == 'dosen' && $user->tipe_dosen == 'wali')
        <!-- Dropdown Kelas khusus untuk Dosen Wali SAJA -->
        <div class="input-group input-group-sm">
            <select class="form-select" id="kelas-{{ $user->id }}">
                <option value="">Pilih Kelas</option>
               <option value="A" {{ in_array('A', explode(',', $dosen->kelas)) ? 'selected' : '' }}>A</option>
    <option value="B" {{ in_array('B', explode(',', $dosen->kelas)) ? 'selected' : '' }}>B</option>
    <option value="C" {{ in_array('C', explode(',', $dosen->kelas)) ? 'selected' : '' }}>C</option>
            </select>
            <button class="btn btn-primary" onclick="simpanKelas({{ $user->id }})">Simpan</button>
        </div>

    @else
        <!-- Jika dosen bukan wali, atau bukan mahasiswa -->
        <span class="text-muted">-</span>
    @endif
</td>
            <!-- Kolom Aksi -->
            <td>
                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="loadView({{ $user->id }})">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="loadEdit({{ $user->id }})">
                    <i class="bi bi-pencil"></i>
                </button>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</section>

<section id="data-kelas">
    <div class="card card-custom p-4">
        <h5>Kelola Data Kelas</h5>
        <hr>
        <form method="GET" action="{{ route('dashboard_admin') }}">
            <!-- Dropdown pilih kelas tetap sama -->
            <select name="kelas" class="form-select w-25" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                <option value="C" {{ request('kelas') == 'C' ? 'selected' : '' }}>Kelas C</option>
            </select>
        </form>

        @if(request('kelas'))
            <div class="mt-4">
                <h5>Dosen Wali Kelas {{ request('kelas') }}:</h5>
                <p>
                  @if(count($dosenWali) > 0)
    @foreach($dosenWali as $dw)
        <strong>{{ $dw->name }}</strong>
    @endforeach
@else
    <span class="text-muted">Belum ada dosen wali</span>
@endif
                </p>

                <h5>Daftar Mahasiswa:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Peran</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $mhs)
                        <tr>
                            <td>Mahasiswa</td>
                            <td>{{ $mhs->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <h5>Detail Pengguna</h5>
            <hr>
            <p><strong>ID:</strong> <span id="view-id"></span></p>
            <p><strong>Nama:</strong> <span id="view-name"></span></p>
            <p><strong>Peran:</strong> <span id="view-role"></span></p>
            <p><strong>Kelas:</strong> <span id="modal-kelas-value"></span></p>

            <!-- Bagian Kelas (Khusus Mahasiswa) -->
           <p id="container-kelas" style="display: none;">
    <strong>Kelas:</strong> <span id="view-kelas"></span>
</p>

            <!-- Bagian Peran Dosen (Khusus Dosen) -->
            <div id="wrapper-dosen" style="display: none;">
                <p><strong>Peran dosen:</strong> <span id="view-tipe-dosen"></span></p>
            </div>

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
<div class="modal fade" id="matkulModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="matkulForm" method="POST" class="modal-content p-4">
            @csrf @method('PUT')
            <h5 id="matkul-modal-title">Detail Mata Kuliah</h5>
            <hr>
            <div id="matkul-modal-body">
                </div>
            <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary mt-3" id="save-matkul-btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" class="modal-content p-4">
            @csrf @method('PUT')
            <h5>Edit Pengguna</h5>
            <input type="text" name="name" id="edit-name" class="form-control mb-2" required>
            <select name="role" id="edit-role" class="form-select mb-2">
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.nav-link-admin').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Hapus class active dari semua link dan section
        document.querySelectorAll('.nav-link-admin').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('section').forEach(el => el.classList.remove('active-section'));
        
        // Tambahkan class active ke link yang diklik dan section target
        this.classList.add('active');
        const target = this.getAttribute('data-target');
        document.getElementById(target).classList.add('active-section');
    });
});
    
    document.getElementById('searchUser').addEventListener('keyup', function() {
    let input = this.value.toLowerCase();
    // Ganti #data-pengguna dengan ID section Anda yang benar
    let table = document.querySelector('#data-pengguna table'); 
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk melewatkan baris header
        let row = rows[i];
        let namaUser = row.cells[1].innerText.toLowerCase(); // Kolom ke-2 adalah Nama
        
        if (namaUser.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
});
  let db = JSON.parse(localStorage.getItem('db_si_pekas')) || { matkul: [], users: [] };
  const modal = new bootstrap.Modal(document.getElementById('editModal'));
function detailPengguna(userId) {
    fetch(`/user/show/${userId}`)
    .then(response => response.json())
    .then(data => {
        // ... isi ID, Nama, Peran ...
        
        // Logika Pembeda Kelas
        const modalKelas = document.getElementById('modal-kelas-value');
        const modalLabel = document.getElementById('modal-kelas-label');

        if (data.kelas) {
            // Jika mahasiswa, labelnya "Kelas", jika dosen "Kelas Bimbingan"
            modalLabel.innerText = (data.role === 'mahasiswa') ? 'Kelas: ' : 'Kelas Bimbingan: ';
            modalKelas.innerText = data.kelas;
        } else {
            modalLabel.innerText = 'Kelas: ';
            modalKelas.innerText = '-';
        }
    });
}
function loadView(id) {
    fetch(`/user/${id}`) // Pastikan endpoint ini mengembalikan JSON yang berisi tipe_dosen
        .then(res => res.json())
        .then(data => {
            document.getElementById('view-id').innerText = data.id;
            document.getElementById('view-name').innerText = data.name;
            document.getElementById('view-role').innerText = data.role.toUpperCase();
            document.getElementById('modal-kelas-value').innerText = data.kelas_tampil;
            
            // Isi tipe dosen secara dinamis
            const tipeDisplay = data.tipe_dosen ? data.tipe_dosen : 'Belum ditentukan';
            document.getElementById('view-tipe-dosen').innerText = tipeDisplay;
            
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        });
}

function simpanTipe(userId) {
    const btn = event.target;
    let tipe = document.getElementById('tipe-' + userId).value;

    fetch('{{ route("user.updateTipe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id: userId,
            tipe_dosen: tipe
        })
    })
    .then(response => response.json())
  .then(data => {
    if(data.success) {
        alert(data.message);
        location.reload();
    } else {
        // Ini akan menampilkan notifikasi "Kelas sudah dipilih oleh dosen lain"
        alert('Gagal: ' + data.message); 
    }
})
    .catch(error => {
        alert('Terjadi kesalahan pada server.');
    });
}
function simpanKelas(userId) {
    const btn = event.target;
    const kelasValue = document.getElementById('kelas-' + userId).value;

    btn.innerText = 'Menyimpan...';
    
    fetch('{{ route("user.updateKelas") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: userId, kelas: kelasValue })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message); // Munculkan pesan sukses
            location.reload();   // Refresh agar data benar-benar terupdate
        } else {
            alert(data.message); // Munculkan pesan "Gagal: Kelas sudah dipegang..."
        }
        btn.innerText = 'Simpan';
    })
    .catch(error => {
        alert('Terjadi kesalahan koneksi.');
        btn.innerText = 'Simpan';
    });
}
// Tambahkan script ini di bagian <script> Anda
const modalElement = document.getElementById('viewModal');
modalElement.addEventListener('hidden.bs.modal', function () {
    // Menghapus sisa-sisa backdrop secara manual
    const backdrops = document.getElementsByClassName('modal-backdrop');
    for (let i = 0; i < backdrops.length; i++) {
        backdrops[i].remove();
    }
    // Mengembalikan scroll ke body jika terkunci
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
});

document.getElementById('searchMatkul').addEventListener('keyup', function() {
    let input = this.value.toLowerCase();
    let table = document.getElementById('data-matkul').querySelector('table');
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk melewatkan header
        let row = rows[i];
        let kode = row.cells[0].innerText.toLowerCase();
        let nama = row.cells[1].innerText.toLowerCase();
        
        if (kode.includes(input) || nama.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
});

  function openAdd(t) {
    document.getElementById('edit-type').value = t; document.getElementById('edit-mode').value = 'add';
    document.getElementById('modal-title').innerText = 'Tambah Data';
    document.querySelector('.btn-primary[onclick="saveData()"]').style.display = 'block';
    let html = t === 'matkul' ? `<div class="col-12"><label>Kode</label><input id="m-kode" class="form-control"></div><div class="col-12"><label>Nama Matkul</label><input id="m-nama" class="form-control"></div><div class="col-12"><label>SKS</label><input type="number" id="m-sks" class="form-control"></div><div class="col-12"><label>Semester</label><input type="number" id="m-semester" class="form-control"></div>` : `<div class="col-12"><label>ID</label><input id="m-id" class="form-control"></div><div class="col-12"><label>Nama</label><input id="m-name" class="form-control"></div><div class="col-12"><label>Peran</label><select id="m-role" class="form-select"><option value="mhs">Mahasiswa</option><option value="dsn">Dosen</option></select></div>`;
    document.getElementById('modal-fields').innerHTML = html; modal.show();
  }

  function openRead(t, i) {
    document.getElementById('modal-title').innerText = 'Detail Data';
    document.querySelector('.btn-primary[onclick="saveData()"]').style.display = 'none';
    let data = (t === 'matkul') ? db.matkul[i] : db.users[i];
    let html = (t === 'matkul') ? `<p><strong>Kode:</strong> ${data.kode}</p><p><strong>Nama:</strong> ${data.nama}</p><p><strong>SKS:</strong> ${data.sks}</p><p><strong>Semester:</strong> ${data.semester}</p>` : `<p><strong>ID:</strong> ${data.id}</p><p><strong>Nama:</strong> ${data.name}</p><p><strong>Peran:</strong> ${data.role.toUpperCase()}</p>`;
    document.getElementById('modal-fields').innerHTML = html; modal.show();
  }
function loadEdit(id) {
    fetch(`/user/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-role').value = data.role;
            document.getElementById('editForm').action = `/user/${id}`;
        });
}
  function openEdit(t, i) {
    document.getElementById('edit-type').value = t; document.getElementById('edit-idx').value = i; document.getElementById('edit-mode').value = 'edit';
    document.getElementById('modal-title').innerText = 'Edit Data';
    document.querySelector('.btn-primary[onclick="saveData()"]').style.display = 'block';
    let html = t === 'matkul' ? `<div class="col-12"><label>Kode</label><input id="m-kode" value="${db.matkul[i].kode}" class="form-control"></div><div class="col-12"><label>Nama Matkul</label><input id="m-nama" value="${db.matkul[i].nama}" class="form-control"></div><div class="col-12"><label>SKS</label><input type="number" id="m-sks" value="${db.matkul[i].sks}" class="form-control"></div><div class="col-12"><label>Semester</label><input type="number" id="m-semester" value="${db.matkul[i].semester}" class="form-control"></div>` : `<div class="col-12"><label>ID</label><input id="m-id" value="${db.users[i].id}" class="form-control"></div><div class="col-12"><label>Nama</label><input id="m-name" value="${db.users[i].name}" class="form-control"></div>`;
    document.getElementById('modal-fields').innerHTML = html; modal.show();
  }
// Fungsi untuk Read (Lihat Data di Modal)
// Fungsi Read (Lihat Data)
function loadReadMatkul(kode_mk) {
    fetch(`/matakuliah/${kode_mk}/show`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('matkul-modal-title').innerText = 'Detail Mata Kuliah';
            document.getElementById('save-matkul-btn').style.display = 'none'; // Sembunyikan tombol simpan
            document.getElementById('matkul-modal-body').innerHTML = `
                <p><strong>Kode:</strong> ${data.kode_mk}</p>
                <p><strong>Nama:</strong> ${data.nama_mk}</p>
                <p><strong>SKS:</strong> ${data.sks}</p>
                <p><strong>Semester:</strong> ${data.semester}</p>
                <p><strong>Nama Dosen:</strong> ${data.dosen ? data.dosen.name : 'Belum Ditugaskan'}</p>
            `;
            new bootstrap.Modal(document.getElementById('matkulModal')).show();
        });
}

// Fungsi Edit (Tampil Form)
function loadEditMatkul(kode_mk) {
    fetch(`/matakuliah/${kode_mk}/edit`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('matkul-modal-title').innerText = 'Edit Mata Kuliah';
            document.getElementById('save-matkul-btn').style.display = 'block';
            
            // Membuat opsi dropdown dosen secara dinamis
            let dosenOptions = '<option value="">Pilih Dosen</option>';
            // Anda perlu mengirim data $all_dosens ke view, 
            // di sini kita asumsikan data tersedia atau fetch terpisah
            @foreach($all_dosens as $dosen)
                dosenOptions += `<option value="{{ $dosen->id }}" ${data.dosen_id == {{ $dosen->id }} ? 'selected' : ''}>{{ $dosen->name }}</option>`;
            @endforeach

            document.getElementById('matkul-modal-body').innerHTML = `
                <input type="hidden" name="kode_mk" value="${data.kode_mk}">
                <label>Nama Matakuliah</label>
                <input type="text" name="nama_mk" value="${data.nama_mk}" class="form-control mb-2">
                <label>SKS</label>
                <input type="number" name="sks" value="${data.sks}" class="form-control mb-2">
                <label>Semester</label>
                <input type="number" name="semester" value="${data.semester}" class="form-control mb-2">
                <label>Dosen Pengampu</label>
                <select name="dosen_id" class="form-select mb-2">
                    ${dosenOptions}
                </select>
            `;
            document.getElementById('matkulForm').action = `/matakuliah/${data.kode_mk}/update`;
            new bootstrap.Modal(document.getElementById('matkulModal')).show();
        });
}
  function saveData() {
    let t = document.getElementById('edit-type').value, mode = document.getElementById('edit-mode').value, i = document.getElementById('edit-idx').value;
    if(mode === 'add') {
        if(t === 'matkul') db.matkul.push({kode: document.getElementById('m-kode').value, nama: document.getElementById('m-nama').value, sks: document.getElementById('m-sks').value, semester: document.getElementById('m-semester').value});
        else db.users.push({id: document.getElementById('m-id').value, name: document.getElementById('m-name').value, role: document.getElementById('m-role').value});
    } else {
        if(t === 'matkul') db.matkul[i] = {kode: document.getElementById('m-kode').value, nama: document.getElementById('m-nama').value, sks: document.getElementById('m-sks').value, semester: document.getElementById('m-semester').value};
        else db.users[i] = {id: document.getElementById('m-id').value, name: document.getElementById('m-name').value, role: db.users[i].role};
    }
    alert('Data berhasil disimpan!'); modal.hide(); render();
  }

  function del(t, i) { if(confirm('Hapus data ini?')) { db[t].splice(i, 1); render(); } }
  function confirmLogout() { if(confirm('Apakah Anda yakin ingin keluar dari sistem?')) window.location.href = 'login'; }

  document.querySelectorAll('.nav-link-admin').forEach(l => l.onclick = function(e) {
    e.preventDefault(); document.querySelectorAll('.nav-link-admin').forEach(a => a.classList.remove('active')); document.querySelectorAll('section').forEach(s => s.classList.remove('active-section'));
    this.classList.add('active'); document.getElementById(this.getAttribute('data-target')).classList.add('active-section'); localStorage.setItem('last_menu', this.getAttribute('data-target'));
  });

  document.querySelector(`[data-target="${localStorage.getItem('last_menu') || 'dash'}"]`).click();
  render();
</script>
</body>
</html