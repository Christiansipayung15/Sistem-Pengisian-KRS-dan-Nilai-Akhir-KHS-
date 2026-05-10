<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data user dari tabel users
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    
    if ($data) {
        // Cek apakah password yang diketik sesuai dengan password di database
        if (password_verify($password, $data['password'])) {
            // JIKA BENAR: Simpan session dan arahkan ke dashboard yang sesuai
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] == 'mahasiswa') {
                header("location:Dashboard_Mahasiswa.php");
            } elseif ($data['role'] == 'dosen') {
                header("location:Dashboard_Dosen.php");
            }
        } else {
            // JIKA PASSWORD SALAH: Munculkan pesan peringatan
            echo "<script>
                    alert('Password salah! Gagal masuk.');
                    window.history.back();
                  </script>";
        }
    } else {
        // JIKA USERNAME TIDAK DITEMUKAN
        echo "<script>
                alert('Username tidak terdaftar!');
                window.history.back();
              </script>";
    }
}
?>