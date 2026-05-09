<?php
// Konfigurasi Data (Mengambil Nama Otomatis dari Login)
if (isset($_POST['nama_dosen'])) {
    $lecturerName = $_POST['nama_dosen'];
} else {
    $lecturerName = "Dr. Aris Sudaryanto"; // Nama cadangan jika akses langsung tanpa login
}

$academicYear = "2024/2025";

$ampuData = [
    'IF101' => ['nama' => 'Pemrograman Web', 'sks' => 3, 'semester' => 'Genap'],
    'IF202' => ['nama' => 'Basis Data', 'sks' => 4, 'semester' => 'Genap']
];

$students = [
    ['nim' => '3312511087', 'nama' => 'Lambok Christian Sipayung'],
    ['nim' => '3312101002', 'nama' => 'Budi Setiawan']
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - Sistem KRS & KHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
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
        
        /* Efek Transisi untuk Delete */
        .fade-out { opacity: 0; transform: translateX(20px); transition: 0.4s ease; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <img src="logo poltek.png" alt="Logo">
            <div class="brand-text">
                <span class="brand-title">Si Pekas Polibatam</span>
                <span class="brand-subtitle">Dashboard Dosen</span>
            </div>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" data-target="dashboard"><i class="bi bi-grid me-2"></i> Dashboard</a>
            <a class="nav-link" data-target="matkul-ampu"><i class="bi bi-book me-2"></i> Matakuliah Diampu</a>
            <a class="nav-link" data-target="input-nilai"><i class="bi bi-pencil-square me-2"></i> Input Nilai Akhir</a>
            <hr class="border-secondary">
            <a href="#" class="nav-link text-warning" onclick="confirmLogout()"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a>
        </nav>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Dashboard Dosen</h4>
                <p class="text-muted">Selamat Datang, <strong><?php echo $lecturerName; ?></strong></p>
            </div>
            <div class="badge bg-info text-dark p-2">Tahun Ajaran <?php echo $academicYear; ?></div>
        </div>

        <section id="dashboard" class="active-section">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card card-custom p-4 border-start border-primary border-4 text-center">
                        <h6 class="text-muted small">Mata Kuliah Diampu</h6>
                        <h2 class="fw-bold"><?php echo count($ampuData); ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 border-start border-success border-4 text-center">
                        <h6 class="text-muted small">Total Mahasiswa</h6>
                        <h2 class="fw-bold" id="counter-mhs"><?php echo count($students); ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 border-start border-warning border-4 text-center">
                        <h6 class="text-muted small">Progress Input Nilai</h6>
                        <h2 class="fw-bold">75%</h2>
                    </div>
                </div>
            </div>
        </section>

        <section id="matkul-ampu">
            <h5 class="fw-bold mb-3">Daftar Mata Kuliah yang Anda Ampu</h5>
            <div class="row g-3">
                <?php foreach ($ampuData as $code => $data): ?>
                <div class="col-md-6">
                    <div class="card card-custom p-4">
                        <span class="badge bg-primary w-25 mb-2"><?php echo $code; ?></span>
                        <h5 class="fw-bold"><?php echo $data['nama']; ?></h5>
                        <p class="text-muted mb-3">SKS: <?php echo $data['sks']; ?> | Semester: <?php echo $data['semester']; ?></p>
                        <button class="btn btn-sm btn-outline-primary" onclick="goToInput('<?php echo $code; ?>')">Input Nilai Kelas</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="input-nilai">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2"></i>Input Nilai: <span id="matkul-title">Pilih Matakuliah</span></h5>
                        <small class="text-muted" id="matkul-code">Kode Matakuliah</small>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-success" onclick="saveAllGrades()"><i class="bi bi-send-check me-1"></i> Simpan Semua</button>
                        <button class="btn btn-sm btn-secondary" onclick="backToMatkul()"><i class="bi bi-arrow-left"></i> Kembali</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th style="width: 180px;">Nilai Akhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="student-list">
                            <?php foreach ($students as $index => $s): 
                                $rowId = $index + 1; ?>
                            <tr class="student-row" id="student-row-<?php echo $rowId; ?>">
                                <td class="fw-bold nim-col"><?php echo $s['nim']; ?></td>
                                <td><?php echo $s['nama']; ?></td>
                                <td>
                                    <select class="form-select select-nilai" id="nilai-<?php echo $rowId; ?>">
                                        <option value="">-- Pilih --</option>
                                        <?php foreach (['A', 'B', 'C', 'D', 'E'] as $grade): ?>
                                            <option value="<?php echo $grade; ?>"><?php echo $grade; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><span id="status-<?php echo $rowId; ?>" class="badge bg-warning text-dark">Belum Input</span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" onclick="saveGrade('<?php echo $rowId; ?>', '<?php echo $s['nim']; ?>')">
                                            <i class="bi bi-save"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteStudent('<?php echo $rowId; ?>', '<?php echo $s['nama']; ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script>
        const ampuData = <?php echo json_encode($ampuData); ?>;
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

        function goToInput(matkulCode) {
            const matkul = ampuData[matkulCode];
            document.getElementById('matkul-title').innerText = matkul.nama;
            document.getElementById('matkul-code').innerText = matkulCode;
            document.querySelector('[data-target="input-nilai"]').click();
        }

        function backToMatkul() {
            document.querySelector('[data-target="matkul-ampu"]').click();
        }

        // FUNGSI DELETE (CRUD - DELETE)
        function deleteStudent(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${nama} dari daftar kelas ini?`)) {
                const row = document.getElementById(`student-row-${id}`);
                
                // Menambahkan animasi fade-out
                row.classList.add('fade-out');
                
                setTimeout(() => {
                    row.remove();
                    // Update counter di dashboard
                    const counter = document.getElementById('counter-mhs');
                    const currentCount = document.querySelectorAll('.student-row').length;
                    counter.innerText = currentCount;
                }, 400);
            }
        }

        function saveGrade(id, nim) { 
            const selectElement = document.getElementById(`nilai-${id}`);
            const grade = selectElement.value;
            const statusLabel = document.getElementById(`status-${id}`);
            if (!grade) { alert("Pilih nilai!"); return; }
            if (confirm(`Simpan nilai ${grade} untuk NIM ${nim}?`)) {
                commitSave(selectElement, statusLabel);
            }
        }

        function saveAllGrades() {
            const rows = document.querySelectorAll('.student-row');
            let count = 0;
            if(confirm("Simpan semua nilai?")) {
                rows.forEach((row) => {
                    const id = row.id.replace('student-row-', '');
                    const select = document.getElementById(`nilai-${id}`);
                    const status = document.getElementById(`status-${id}`);
                    if(select.value && !select.disabled) {
                        commitSave(select, status);
                        count++;
                    }
                });
                alert(count > 0 ? `Berhasil menyimpan ${count} nilai.` : "Tidak ada data baru.");
            }
        }

        function commitSave(el, label) {
            label.className = "badge bg-success";
            label.innerText = "Tersimpan";
            el.disabled = true;
        }

        function confirmLogout() {
            if (confirm("Keluar sistem?")) window.location.href = "Login_Dosen.php";
        }
    </script>
</body>
</html>