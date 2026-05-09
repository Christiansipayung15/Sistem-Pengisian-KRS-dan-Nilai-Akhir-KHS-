<?php
session_start();
// Jika ingin memastikan nama selalu terbaru, kita ambil dari session yang diset saat login
$nama_user = isset($_SESSION['username']) ? $_SESSION['username'] : "Mahasiswa";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Mahasiswa | Si Pekas Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2d9d6c5f8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body { background-color: #f8faff; font-family: 'Poppins', sans-serif; }
        .sidebar { height: 100vh; width: 260px; background-color: #0f172a; padding-top: 20px; position: fixed; z-index: 1000; }
        .sidebar-brand { display: flex; align-items: center; padding: 0 20px; margin-bottom: 30px; }
        .brand-logo { width: 45px; height: 45px; background-color: #1e293b; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-right: 12px; overflow: hidden; }
        .brand-text { line-height: 1.2; }
        .brand-text h6 { margin: 0; font-weight: 800; color: #ffffff; font-size: 16px; }
        .brand-text span { font-size: 13px; color: #94a3b8; }
        .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: 12px 20px; border-radius: 10px; margin: 5px 15px; transition: 0.3s; cursor: pointer; }
        .sidebar a.active { background-color: #3b82f6; color: #fff; font-weight: 600; }
        .sidebar a:hover:not(.active) { background-color: #1e293b; color: #3b82f6; }
        .content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); }
        .card-stat { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: #fff; }
        section { display: none; }
        section.active-section { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .profile-section { display: flex; align-items: center; background: #fff; padding: 8px 15px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .profile-avatar { width: 40px; height: 40px; background-color: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; margin-right: 12px; text-transform: uppercase; }
        .profile-info { line-height: 1.2; }
        .profile-info .name { font-size: 14px; font-weight: bold; margin: 0; }
        .profile-info .nim { font-size: 12px; color: #777; margin: 0; }
        .table-primary-selected { background-color: #e0e7ff !important; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <img src="logo poltek.png" alt="Logo" style="width: 80%; height: 80%; object-fit: contain;">
            </div>
            <div class="brand-text">
                <h6>Si Pekas Polibatam</h6>
                <span>Dashboard Mahasiswa</span>
            </div>
        </div>
        <a class="nav-link-custom active" data-target="dashboard"><i class="fas fa-home me-2"></i> Dashboard</a>
        <a class="nav-link-custom" data-target="krs"><i class="fas fa-edit me-2"></i> Pengambilan KRS</a>
        <a class="nav-link-custom" data-target="khs"><i class="fas fa-file-invoice me-2"></i> Lihat KHS</a>
        <hr class="mx-3 border-secondary">
        <a class="text-warning" onclick="confirmLogout()"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Dashboard Mahasiswa</h4>
               <p class="text-muted">Hi, <strong id="user-fullname">Memuat...</strong>! 👋</p>
            </div>
            <div class="profile-section">
                <div class="profile-avatar" id="profile-initial">--</div>
               <div class="profile-info">
    <p class="name" id="display-name">Memuat...</p>
    <p class="nim">Mahasiswa</p> </div>
            </div>
        </div>

        <section id="dashboard" class="active-section">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card card-stat p-4 border-start border-primary border-4">
                        <h6 class="text-muted small fw-bold">IP SEMESTER LALU</h6>
                        <h2 class="fw-bold text-primary">3.45</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stat p-4 border-start border-success border-4">
                        <h6 class="text-muted small fw-bold">MAKSIMAL SKS</h6>
                        <h2 class="fw-bold text-success">24 SKS</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stat p-4 border-start border-warning border-4">
                        <h6 class="text-muted small fw-bold">SKS TERPILIH (KRS)</h6>
                        <h2 class="fw-bold text-warning"><span id="current-sks-dash">0</span> SKS</h2>
                    </div>
                </div>
            </div>
        </section>

        <section id="krs">
            <div class="card card-stat p-4" id="area-krs">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold"><i class="fas fa-tasks me-2"></i>Pengambilan KRS</h5>
                    <div class="filter-area">
                        <select class="form-select form-select-sm w-auto" id="filter-semester">
                            <option value="1">Semester 1</option>
                            <option value="2" selected>Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                        </select>
                    </div>
                </div>
                <div class="alert alert-info py-2 small border-0">
                    Total SKS Terpilih: <strong id="total-sks">0</strong> / 24 SKS.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="no-print">Pilih</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Sem</th>
                                <th>Dosen</th>
                            </tr>
                        </thead>
                        <tbody id="krs-table">
                            <tr data-semester="1">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="3"></td>
                                <td>IF101</td>
                                <td>Logika Matematika</td>
                                <td>3</td>
                                <td>1</td>
                                <td>Drs. Budi Setiawan</td>
                            </tr>
                            <tr data-semester="1">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="2"></td>
                                <td>IF102</td>
                                <td>Pengantar Informatika</td>
                                <td>2</td>
                                <td>1</td>
                                <td>Siti Aminah, M.Kom</td>
                            </tr>

                            <tr data-semester="2">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="3"></td>
                                <td>IF201</td>
                                <td>Pemrograman Web (Laravel)</td>
                                <td>3</td>
                                <td>2</td>
                                <td>Dr. Aris Sudaryanto</td>
                            </tr>
                            <tr data-semester="2">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="4"></td>
                                <td>IF202</td>
                                <td>Basis Data (MySQL)</td>
                                <td>4</td>
                                <td>2</td>
                                <td>Evaliata Br. Sembiring</td>
                            </tr>

                            <tr data-semester="3">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="3"></td>
                                <td>IF301</td>
                                <td>Struktur Data</td>
                                <td>3</td>
                                <td>3</td>
                                <td>Hendra Putra, M.T</td>
                            </tr>

                            <tr data-semester="4">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="3"></td>
                                <td>IF401</td>
                                <td>Sistem Operasi</td>
                                <td>3</td>
                                <td>4</td>
                                <td>Andi Wijaya, M.Sc</td>
                            </tr>

                            <tr data-semester="5">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="4"></td>
                                <td>IF501</td>
                                <td>Kecerdasan Buatan</td>
                                <td>4</td>
                                <td>5</td>
                                <td>Rina Sari, Ph.D</td>
                            </tr>

                            <tr data-semester="6">
                                <td class="no-print"><input type="checkbox" class="krs-cb" data-sks="6"></td>
                                <td>IF601</td>
                                <td>Proyek Akhir / Magang</td>
                                <td>6</td>
                                <td>6</td>
                                <td>Tim Dosen PBL</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3 no-print">
                    <button class="btn btn-outline-secondary me-2" onclick="downloadPDF('area-krs', 'KRS_Mahasiswa')">Export PDF</button>
                    <button class="btn btn-primary px-4" onclick="alert('KRS Berhasil Disimpan!')">Simpan KRS</button>
                </div>
            </div>
        </section>

        <section id="khs">
            <div class="card card-stat p-4" id="area-khs">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold">Kartu Hasil Studi (KHS)</h5>
                    <button class="btn btn-sm btn-outline-primary no-print" onclick="downloadPDF('area-khs', 'KHS_Mahasiswa')">Export PDF</button>
                </div>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>IF101</td><td class="text-start">Pemrograman Web</td><td>3</td><td>A</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
    let totalSks = 0;

    // FUNGSI OTOMATISASI NAMA
function loadUserData() {
    // 1. Ambil nama dari localStorage (yang diset di Login_Mahasiswa.php)
    const savedName = localStorage.getItem('loggedUserName') || "Mahasiswa";

    // 2. Update teks Nama di Dashboard
    if(document.getElementById('user-fullname')) {
        document.getElementById('user-fullname').innerText = savedName;
    }
    if(document.getElementById('display-name')) {
        document.getElementById('display-name').innerText = savedName;
    }

    // 3. Buat Inisial Profile otomatis (Contoh: Lambok Christian -> LC)
    const initials = savedName.split(' ')
                               .filter(word => word.length > 0)
                               .map(n => n[0])
                               .join('')
                               .substring(0, 2)
                               .toUpperCase();
    
    const profileElement = document.getElementById('profile-initial');
    if(profileElement) {
        profileElement.innerText = initials;
    }
}

    window.onload = function() {
        loadUserData();
        filterTable('2');
    };

    // Navigasi
    document.querySelectorAll('.nav-link-custom').forEach(link => {
        link.onclick = function() {
            document.querySelectorAll('.nav-link-custom').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('section').forEach(s => s.classList.remove('active-section'));
            document.getElementById(this.getAttribute('data-target')).classList.add('active-section');
        };
    });

    // Filter Table berdasarkan Semester
    document.getElementById('filter-semester').onchange = function() { 
        filterTable(this.value); 
    };

    function filterTable(sem) {
        document.querySelectorAll('#krs-table tr').forEach(row => {
            if (row.getAttribute('data-semester') === sem) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Hitung SKS & Validasi
    document.querySelectorAll('.krs-cb').forEach(cb => {
        cb.onchange = function() {
            let val = parseInt(this.getAttribute('data-sks'));
            let row = this.closest('tr');

            if(this.checked) {
                if(totalSks + val > 24) { 
                    alert("Maksimal 24 SKS!"); 
                    this.checked = false; 
                } else { 
                    totalSks += val; 
                    row.classList.add('table-primary-selected');
                }
            } else { 
                totalSks -= val; 
                row.classList.remove('table-primary-selected');
            }
            
            document.getElementById('total-sks').innerText = totalSks;
            document.getElementById('current-sks-dash').innerText = totalSks;
        };
    });

    // Export PDF
    function downloadPDF(elementId, filename) {
        const element = document.getElementById(elementId);
        const userName = document.getElementById('user-fullname').innerText.replace(/\s+/g, '_');
        const finalFilename = filename + "_" + userName;

        const noPrint = element.querySelectorAll('.no-print, .filter-area');
        noPrint.forEach(el => el.style.display = 'none');

        const options = {
            margin: 10,
            filename: finalFilename + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(options).from(element).save().then(() => {
            noPrint.forEach(el => el.style.display = '');
        });
    }

  function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "Login_Mahasiswa.php"; // Kembali ke login
            }
        }
</script>

</body>
</html>