<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef5ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 400px; padding: 2rem; background: white; }
        .btn-primary { background-color: #004d99; border: none; font-weight: 600; }
        .logo { width: 80px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="card text-center">
    <img src="logo poltek.png" alt="Logo Polibatam" class="logo mx-auto">
    <h5 class="fw-bold mb-1">Pemulihan Password</h5>
    <p class="text-muted small mb-4">Pengolahan KRS & KHS</p>

    <form action="proses_lupa_password.php" method="POST">
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">Peran</label>
            <select name="peran" class="form-select" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">NIM / NIDN</label>
            <input type="text" name="nomor_induk" class="form-control" placeholder="Masukkan nomor induk" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">Password Baru</label>
            <input type="password" name="new_password" class="form-control" placeholder="Min. 8 karakter" required>
        </div>

        <button type="submit" name="submit_reset" class="btn btn-primary w-100" 
        onclick="return confirm('Konfirmasi perubahan password sedang diproses. Apakah Anda yakin ingin memperbarui dan login?')">
    Update & Login
</button>
    </form>
    
  <script>
        const form = document.querySelector('form');
        form.onsubmit = function() {
            const btn = document.querySelector('.btn-primary');
            btn.innerHTML = "Memproses Perubahan...";
            // btn.disabled = true; // Catatan: Jika di-disable di sini, kadang data form tidak terkirim di beberapa browser. 
            // Lebih baik biarkan aktif atau gunakan setTimeOut.
            
            alert("Konfirmasi perubahan password sedang dalam proses. Harap tunggu sejenak.");
        };
    </script>


</body>
</html>