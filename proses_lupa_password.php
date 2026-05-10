<?php
// 1. ISI DULU VARIABELNYA (Pastikan ini ada di baris paling atas setelah <?php)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pengolahan krs&khs"; // GANTI dengan nama database Anda yang sebenarnya

// 2. BARU LAKUKAN KONEKSI
$koneksi = mysqli_connect($host, $user, $pass, $db);


// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 3. LOGIKA FORM (isset submit, dll)
if (isset($_POST['submit_reset'])) {
    
    // Ambil data dari form
    $peran        = mysqli_real_escape_string($koneksi, $_POST['peran']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nomor_induk  = mysqli_real_escape_string($koneksi, $_POST['nomor_induk']);
    $new_password = $_POST['new_password'];

    // --- DI SINI TEMPATNYA (Baris 26) ---
    // Gunakan 'user' jika itu nama tabel di database Anda, atau 'pengguna' sesuai rencana awal
$query_cek = "SELECT * FROM users WHERE username='$username' AND id_user='$nomor_induk' AND role='$peran'";
    $eksekusi_cek = mysqli_query($koneksi, $query_cek);

   if (mysqli_num_rows($eksekusi_cek) > 0) {
        
        // 3. Update Password (menggunakan password_hash demi keamanan)
        $password_enkripsi = password_hash($new_password, PASSWORD_DEFAULT);
        $query_update = "UPDATE users SET password='$password_enkripsi' WHERE username='$username'";
        
        if (mysqli_query($koneksi, $query_update)) {
            
            // 4. Logika Pengalihan Berdasarkan Peran (Role)
            if ($peran == "dosen") {
                echo "<script>
                        alert('Password Dosen berhasil diperbarui! Mengalihkan ke Dashboard Dosen...');
                        window.location.href = 'dashboard_dosen.php'; 
                      </script>";
            } else if ($peran == "mahasiswa") {
               echo "<script>
                alert('Password berhasil diperbarui! Silakan coba login.');
                window.location.href = 'Login_Mahasiswa.php'; 
              </script>";
            }

        } else {
            echo "Terjadi kesalahan saat memperbarui: " . mysqli_error($koneksi);
        }

    } else {
        // Jika data tidak ditemukan
        echo "<script>
                alert('Data tidak cocok! Username atau Nomor Induk salah.');
                window.history.back();
              </script>";
    }
}

mysqli_close($koneksi);
?>