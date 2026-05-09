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
    <p class="text-muted mb-4">Login Admin</p>

 <!-- Cari bagian <form> di Login_admin.php kamu -->
<form action="proses_login.php" method="POST">
  <div class="mb-3 text-start">
    <label class="form-label">Username</label>
    <!-- Tambahkan name="user_admin" -->
    <input type="text" name="user_admin" class="form-control" placeholder="Masukkan username" required>
  </div>
  <div class="mb-3 text-start">
    <label class="form-label">Password</label>
    <!-- Tambahkan name="pass_admin" -->
    <input type="password" name="pass_admin" class="form-control" placeholder="Masukkan password" required>
  </div>
  <button type="submit" class="btn btn-primary w-100">Masuk</button>
</form>

 
    <small class="text-muted d-block mt-3">© 2026 Politeknik Negeri Batam. All rights reserved.</small>
  </div>

</body>
</html>