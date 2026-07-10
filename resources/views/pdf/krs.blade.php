<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f8f9fa; text-align: left; padding: 12px; border-bottom: 1px solid #dee2e6; }
        td { padding: 12px; border-bottom: 1px solid #dee2e6; color: #333; }
    </style>
</head>
<body>
    <h2>Kartu Rencana Studi</h2>
    <p>Nama: {{ $user->name }}</p>
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
            {{-- Mengecek apakah data ada sebelum melakukan looping --}}
            @forelse($krs as $item)
            <tr>
                <td>{{ $item->kode_mk }}</td>
                <td>{{ $item->matakuliah->nama_mk ?? 'Data tidak tersedia' }}</td>
                <td>{{ $item->matakuliah->sks ?? '0' }}</td>
                <td>{{ $item->dosen ? $item->dosen->nama : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada mata kuliah yang diambil.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>