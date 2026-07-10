@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Tambah Kelas Baru</h2>
    
    <form action="{{ route('kelas.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Pilih Mata Kuliah:</label>
            <select name="kode_mk" class="form-control" required>
                @foreach($matakuliahs as $mk)
                    <option value="{{ $mk->kode_mk }}">{{ $mk->nama_mk }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Pilih Dosen Pengampu:</label>
            <select name="nip_dosen" class="form-control" required>
                @foreach($dosens as $dsn)
                    <option value="{{ $dsn->nip }}">{{ $dsn->nama_dosen }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Semester:</label>
            <input type="number" name="semester_buka" class="form-control" placeholder="Contoh: 2" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Kelas</button>
    </form>
</div>
@endsection