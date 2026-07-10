<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="info">
        <h3>Kartu Rencana Studi (KRS)</h3>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>NIM:</strong> {{ $user->identity_number }}</p>
        <p><strong>Semester:</strong> {{ $semester }}</p>
        <p><strong>Total SKS:</strong> {{ $totalSks }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Dosen Pengampu</th>
            </tr>
        </thead>
        <tbody>
            {{-- Mengakses data melalui relasi jika ada --}}
            @foreach($krsData as $item)
            <tr>
                <td>{{ $item->kode_mk }}</td>
                {{-- Jika nama_mk ada di relasi matakuliah, gunakan $item->matakuliah->nama_mk --}}
                <td>{{ $item->nama_mk ?? ($item->matakuliah->nama_mk ?? 'Tidak ada data') }}</td>
                {{-- Jika sks ada di relasi matakuliah, gunakan $item->matakuliah->sks --}}
                <td>{{ $item->sks ?? ($item->matakuliah->sks ?? 0) }}</td>
                <td>{{ $item->dosen ? $item->dosen->name : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>