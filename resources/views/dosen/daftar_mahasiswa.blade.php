<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa - {{ $kode_mk }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3>Daftar Mahasiswa untuk Matakuliah: {{ $kode_mk }}</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($dataMahasiswa as $item)
            <tr>
                <td>{{ $item->mahasiswa->name ?? 'Tidak ada data' }}</td>
                <td>{{ $item->mahasiswa->identity_number ?? 'Tidak ada data' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    <td>
   
</td>
  
    
</body>
</html>