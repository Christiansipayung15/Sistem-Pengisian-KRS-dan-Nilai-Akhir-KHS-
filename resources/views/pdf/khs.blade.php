<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Hasil Studi</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid black; padding: 8px; vertical-align: middle; }
        th { text-align: center; background-color: #f8f8f8; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div style="margin-bottom: 20px;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;">Nama Mahasiswa</td>
                <td style="border: none; width: 10px;">:</td>
                <td style="border: none;">{{ $user->name }}</td>
            </tr>
          <tr style="border: none;">
            <td style="border: none;">NIM</td>
            <td style="border: none;">:</td>
            <td style="border: none;">{{ $user->nim }}</td>
        </tr>
            <tr style="border: none;">
                <td style="border: none;">Semester</td>
                <td style="border: none;">:</td>
                <td style="border: none;">1</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE</th>
                <th>MATA KULIAH</th>
                <th>SKS</th>
                <th>NILAI AKHIR</th>
                <th>ANGKA</th>
                <th>K x N</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataKHS as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}.</td>
                <td class="text-center">{{ $item->matakuliah->kode_mk }}</td>
                <td>{{ $item->matakuliah->nama_mk }}</td>
                <td class="text-center">{{ $item->matakuliah->sks }}</td>
                <td class="text-center">{{ $item->nilai }}</td>
                <td class="text-center">{{ $item->getAngkaNilai() }}</td>
                <td class="text-center">{{ $item->matakuliah->sks * $item->getAngkaNilai() }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-center font-bold">JUMLAH</td>
                <td class="text-center font-bold">{{ $totalSks }}</td>
                <td></td>
                <td></td>
                <td class="text-center font-bold">{{ $totalKxN }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px;">
        <table style="border: none; width: 350px;">
            <tr style="border: none;">
                <td style="border: none; width: 200px;">Indeks Prestasi Semester</td>
                <td style="border: none; width: 10px;">:</td>
                <td style="border: none;">{{ number_format($ips, 2) }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Indeks Prestasi Kumulatif</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ number_format($ipk, 2) }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Sks yang diambil</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $totalSks }}</td>
            </tr>
        </table>
    </div>

</body>
</html>