<?php
session_start(); // Memulai session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $user = $_POST['nama_dosen'];
    
    // Simpan ke session
    $_SESSION['nama_dosen'] = $user;
    
    // Alihkan ke dashboard
    header("Location: dashboard_dosen.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | APAO Polibatam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e8f3ff, #f8faff);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .card {
      border: none;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
    }
    .logo {
      width: 120px;
      display: block;
      margin: 20px auto 10px;
    }
  </style>
</head>
<body>

  <div class="card p-4 text-center">
    <img src="logo poltek.png" alt="Logo Polibatam" class="logo">
    <h5 class="mb-1">Pengolahan KRS & KHS </h5>
    <p class="text-muted mb-4">Login Dosen</p>

  <form action="" method="POST"> <!-- Action dikosongkan agar diproses script PHP di atas -->
  <div class="mb-3 text-start">
    <label class="form-label">Username</label>
    <input type="text" name="nama_dosen" class="form-control" placeholder="Masukkan nama Anda" required>
  </div>
  
  <div class="mb-3 text-start">
    <div class="d-flex justify-content-between align-items-center">
      <label class="form-label mb-0">Password</label>
      <!-- Link diletakkan sejajar dengan label Password agar hemat ruang -->
    </div>
    <input type="password" name="password" class="form-control mt-1" placeholder="Masukkan password" required>
  </div>
  
  <button type="submit" class="btn btn-primary w-100">Masuk</button>
  
  <!-- Alternatif: Jika ingin diletakkan di bawah tombol seperti permintaan sebelumnya -->
  <div class="text-center mt-3">
    <small class="text-muted">Lupa password? <a href="lupa_password.php" class="text-decoration-none fw-bold">Klik di sini</a></small>
  </div>
</form>

    <small class="text-muted d-block mt-3">© <?php echo date("Y"); ?> Politeknik Negeri Batam. All rights reserved.</small>
  </div>

</body>
</html>