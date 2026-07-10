<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Polibatam</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body { 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: linear-gradient(135deg, #64748b, #1e293b);
        }
        
        .login-card { 
            background: #0f172a; 
            padding: 40px; 
            border-radius: 24px; 
            width: 90%; /* Menggunakan persentase untuk responsivitas */
            max-width: 560px; /* Lebar diperbesar dari 420px ke 480px */
            text-align: center; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo-wrapper { margin-bottom: 25px; display: flex; justify-content: center; }
        .brand-logo { width: 90px; }
        
        h2 { color: #ffffff; margin-bottom: 8px; font-size: 24px; }
        .welcome-text { 
    color: #ffffff; /* Mengubah dari #94a3b8 ke putih */
    margin-bottom: 25px; 
    font-size: 14px; 
}
        
        .form-label { display: block; font-size: 12px; font-weight: 700; color: #e2e8f0; margin-top: 20px; margin-bottom: 8px; text-transform: uppercase; text-align: left; }
        
        .input-wrapper { position: relative; display: flex; align-items: center; width: 100%; }
        .input-icon { position: absolute; left: 14px; color: #3b82f6; font-size: 18px; }
        .field { width: 100%; padding: 15px 15px 15px 45px; background: #1e293b; border: 2px solid #334155; border-radius: 14px; color: white; outline: none; transition: 0.3s; }
        .field:focus { border-color: #3b82f6; background: #0f172a; }
        
        .btn-submit { width: 100%; padding: 15px; background: #3b82f6; color: white; border: none; border-radius: 14px; font-weight: 700; cursor: pointer; margin-top: 35px; transition: 0.3s; }
        .btn-submit:hover { background: #2563eb; transform: translateY(-2px); }
        
        /* Navigasi Auth */
        .auth-links { 
            margin-top: 25px; 
            display: flex; 
            flex-direction: column; 
            gap: 12px;
            font-size: 13px; 
        }
        .auth-links a { 
    color: #ffffff; /* Mengubah dari #94a3b8 ke putih */
    text-decoration: none; 
    transition: 0.3s; 
}
        .auth-links a span { 
            color: #60a5fa; 
            font-weight: 700; 
            text-decoration: underline;
        }
        .auth-links a:hover { 
    color: #60a5fa; /* Warna akan berubah ke biru saat mouse di atasnya */
}
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-wrapper">
            <img src="data:image/png;base64,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" class="brand-logo" alt="Logo">
        </div>

       <h2>Selamat Datang</h2>
        <p class="welcome-text">Sistem Informasi Akademik: Akses Terpadu untuk KRS dan KHS.</p>

        @if ($errors->any())
            <div style="color: #f87171; background: #450a0a; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; border: 1px solid #7f1d1d;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div style="color: #4ade80; background: #064e3b; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; border: 1px solid #065f46;">
                {{ session('success') }}
            </div>
        @endif
     
    <form id="loginForm" action="{{ route('login.post') }}" method="POST"> 
    @csrf 
    
    <label class="form-label">Pilih Akses</label>
    <div class="input-wrapper">
        <ion-icon name="people-outline" class="input-icon"></ion-icon>
        <select class="field" name="role" id="roleSelect" style="cursor: pointer;">
            <option value="dosen">Dosen</option>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <label class="form-label" id="idLabel">NIDN</label>
    <div class="input-wrapper">
        <ion-icon name="id-card-outline" class="input-icon"></ion-icon>
        <input type="text" class="field" name="identity" id="idInput" placeholder="Masukkan ID Anda" required>
    </div>

    <label class="form-label">Password</label>
    <div class="input-wrapper">
        <ion-icon name="lock-closed-outline" class="input-icon"></ion-icon>
        <input type="password" class="field" name="password" placeholder="Masukkan Kata Sandi" required>
    </div>

    <button type="submit" class="btn-submit">MASUK</button>
</form>

            <div class="auth-links">
               <a href="#" onclick="alert('Hubungi admin: 0895-6029-74116 (Daniel)'); return false;"><span>KLIK UNTUK REGISTRASI</span></a>
                <a href="lupa_password">Lupa password? <span>KLIK DISINI</span></a>
            </div>
        </form>
    </div>

   <script>
    const roleSelect = document.getElementById('roleSelect');
    const idLabel = document.getElementById('idLabel');
    
    roleSelect.addEventListener('change', () => {
        if(roleSelect.value === 'mahasiswa') idLabel.textContent = 'NIM';
        else if(roleSelect.value === 'dosen') idLabel.textContent = 'NIDN';
        else idLabel.textContent = 'ID STAF / NIP';
    });
</script>
</body>
</html>