<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Polibatam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: #4B5563;" class="flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md border border-gray-200">
        
        <div class="flex justify-center mb-8">
            <img src="data:image/png;base64,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" alt="Logo Polibatam" class="w-24 h-24 object-contain">
        </div>

        <div class="text-center mb-10">
            <h2 class="text-gray-900 text-3xl font-extrabold mb-2">Daftar Akun Baru</h2>
            <p class="text-gray-600 text-lg">Silakan pilih akses dan lengkapi data Anda.</p>
        </div>
<form action="{{ route('register.store') }}" method="POST" class="space-y-8">
    @csrf <div>
        <label class="block text-gray-800 text-sm font-black uppercase tracking-widest mb-3">PILIH AKSES</label>
        <select name="peran" id="peran" class="w-full bg-gray-50 text-gray-900 text-lg p-5 rounded-2xl border-2 border-gray-300 focus:border-blue-600 outline-none transition font-medium" required>
            <option value="" disabled selected>Pilih...</option>
            <option value="dosen">Dosen</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select>
    </div>
<!-- Tambahkan di dalam form register -->
<div class="space-y-3">
    <label class="block text-gray-800 text-sm font-black uppercase tracking-widest">Email</label>
    <input type="email" name="email" required placeholder="masukkan nama email..." 
           class="w-full bg-gray-50 p-5 rounded-2xl border-2 border-gray-300">
</div>
    <div>
        <label id="label-identitas" class="block text-gray-800 text-sm font-black uppercase tracking-widest mb-3">NOMOR IDENTITAS</label>
<input type="text" 
           name="identity_number" 
           placeholder="Masukkan nomor identitas..." 
           required 
           class="w-full bg-gray-50 text-gray-900 text-lg p-5 rounded-2xl border-2 border-gray-300 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition">
</div>
    
    <div>
        <label class="block text-gray-800 text-sm font-black uppercase tracking-widest mb-3">KATA SANDI</label>
        <input type="password" name="password" class="w-full bg-gray-50 text-gray-900 text-lg p-5 rounded-2xl border-2 border-gray-300 outline-none focus:border-blue-600 transition" placeholder="••••••••" required>
    </div>
    
    <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white p-5 rounded-2xl text-xl font-bold transition shadow-xl">
        Daftar Sekarang
    </button>
</form>
    </div>

    <script>
        document.getElementById('peran').addEventListener('change', function() {
            const labelId = document.getElementById('label-identitas');
            labelId.textContent = this.value === 'dosen' ? 'NIDN' : 'NIM';
        });
    </script>
</body>
</html>