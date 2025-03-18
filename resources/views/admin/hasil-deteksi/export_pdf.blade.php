<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Deteksi Pengguna</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Riwayat Deteksi Pengguna</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Kategori Usia</th>
                <th>Kategori LILA</th>
                <th>Kategori TB</th>
                <th>Kategori Anak</th>
                <th>Kategori TTD</th>
                <th>Kategori ANC</th>
                <th>Kategori TD</th>
                <th>Kategori HB</th>
                <th>Hasil Deteksi</th>
                <th>Tanggal Deteksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilDeteksi as $index => $riwayat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $riwayat->nama_lengkap }}</td>
                    <td>{{ $riwayat->kategori_usia }}</td>
                    <td>{{ $riwayat->kategori_lila }}</td>
                    <td>{{ $riwayat->kategori_tb }}</td>
                    <td>{{ $riwayat->kategori_anak }}</td>
                    <td>{{ $riwayat->kategori_ttd }}</td>
                    <td>{{ $riwayat->kategori_anc }}</td>
                    <td>{{ $riwayat->kategori_td }}</td>
                    <td>{{ $riwayat->kategori_hb }}</td>
                    <td>{{ $riwayat->hasil_deteksi }}</td>
                    <td>{{ $riwayat->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
