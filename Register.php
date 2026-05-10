<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef5ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 450px; padding: 2.5rem; }
        .btn-primary { background-color: #004d99; border: none; padding: 10px; font-weight: 600; }
        .form-control { background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="card">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Pemulihan Akun</h3>
            <p class="text-muted small">Masukkan data Anda untuk meriset password</p>
        </div>

        <form action="proses lupa password.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Peran</label>
                <select name="peran" class="form-select" id="peranSelect" onchange="updatePlaceholder()" required>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username Anda" required>
            </div>

            <div class="mb-3">
                <label id="labelInduk" class="form-label small fw-bold">NIM (Nomor Induk Mahasiswa)</label>
                <input type="text" name="nomor_induk" class="form-control" placeholder="Masukkan NIM" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Password Baru</label>
                <input type="password" name="new_password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>

            <button type="submit" name="reset" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none small" style="color: #004d99;">Kembali ke Login</a>
        </div>
    </div>

    <script>
        function updatePlaceholder() {
            const peran = document.getElementById('peranSelect').value;
            const label = document.getElementById('labelInduk');
            const input = document.getElementsByName('nomor_induk')[0];

            if (peran === 'mahasiswa') {
                label.innerText = 'NIM (Nomor Induk Mahasiswa)';
                input.placeholder = 'Masukkan NIM';
            } else {
                label.innerText = 'NIDN (Nomor Induk Dosen)';
                input.placeholder = 'Masukkan NIDN';
            }
        }
        
    </script>
</body>
</html>