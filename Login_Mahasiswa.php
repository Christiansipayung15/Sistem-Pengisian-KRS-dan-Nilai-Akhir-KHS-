<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil username dari form
    $_SESSION['username'] = $_POST['username']; 
    header("Location: Dashboard_Mahasiswa.php");
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
    <p class="text-muted mb-4">Login Mahasiswa</p>

    <form id="loginForm">
      <div class="mb-3 text-start">
        <label class="form-label">Username:</label>
        <input type="text" id="usernameInput" class="form-control" placeholder="Masukkan Username" required>
      </div>
   <!-- Bagian Input Password -->
<div class="mb-3 text-start">
  <label class="form-label">Password</label>
  <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
  

  
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
 <div class="text-center mt-3">
    <small class="text-muted">Lupa password? <a href="lupa_password.php" class="text-decoration-none fw-bold">Klik di sini</a></small>
  </div>
</form>
    <small class="text-muted d-block mt-3">© 2026 Politeknik Negeri Batam. All rights reserved.</small>
  </div>

  <script>
    document.getElementById('loginForm').onsubmit = function(e) {
        e.preventDefault();
        
        // Ambil nama yang diketik user
        const inputName = document.getElementById('usernameInput').value;
        
        // Simpan ke localStorage agar dibaca oleh fungsi loadUserData() di dashboard Anda
        localStorage.setItem('loggedUserName', inputName);
        localStorage.setItem('loggedUserNim', inputName); // Simulasi NIM menggunakan nama yang sama
        
        // Pindah ke halaman dashboard (pastikan nama filenya sama)
        window.location.href = "Dashboard_Mahasiswa.php";
    };
  </script>

</body>
</html>