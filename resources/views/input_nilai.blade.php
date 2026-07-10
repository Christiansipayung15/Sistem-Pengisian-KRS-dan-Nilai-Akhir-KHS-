<table class="table">
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Nilai Akhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
       @foreach($dataMahasiswa as $item)
<tr>
    <td>{{ $item->mahasiswa->identity_number }}</td> <td>{{ $item->mahasiswa->name }}</td>          
            <td>{{ $item->mahasiswa->name }}</td>
            <td>
                <form action="/simpan-nilai" method="POST">
                    @csrf
                    <input type="hidden" name="krs_id" value="{{ $item->id }}">
                    <input type="number" name="nilai" class="form-control" placeholder="Nilai (0-100)" required>
            </td>
            <td>
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table><form action="/simpan-nilai" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Mahasiswa:</label>
        <input type="text" value="{{ $mahasiswa->name }}" readonly class="form-control">
    </div>
    
    <div class="mb-3">
        <label>NIM:</label>
        <input type="text" value="{{ $mahasiswa->identity_number }}" readonly class="form-control">
    </div>

    <div class="mb-3">
        <label>Masukkan Nilai Akhir:</label>
        <input type="number" name="nilai" class="form-control" required>
    </div>
    
    
</form>