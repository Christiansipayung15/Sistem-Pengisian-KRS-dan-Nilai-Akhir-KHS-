<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
<tbody>
    @foreach($dataKhs as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->krs->matakuliah->kode_mk ?? 'N/A' }}</td>
        <td>{{ $item->krs->matakuliah->nama_mk ?? 'Nama MK belum diset' }}</td>
        <td>{{ $item->krs->matakuliah->sks ?? 0 }}</td>
        <td>{{ $item->dosen ? $item->dosen->nama : '-' }}</td>
    </tr>
    @endforeach
</tbody>
</table>