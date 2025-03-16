{{-- <?php
include '../config.php';
session_start();

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$query = "SELECT * FROM riwayat_deteksi WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?> --}}


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Deteksi Pengguna</title>
    <link rel="stylesheet" href="{{ asset('style-dashboard-admin.css') }}">
    <style>
        .table {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #343a40 !important;
            color: white !important;
            text-align: center;
        }

        .table td, .table th {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
        <link rel="stylesheet" href="{{ asset('style-dashboard-admin.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="header">
    <h1 class="logo">
        <img src="{{ asset('assets/img/logo-01.png') }}">
    </h1>

    <nav class="nav-menu">
        <a href="{{ route('admin.dashboard') }}">Beranda</a>
        <a href="{{ route('admin.hasilDeteksi.index') }}">Kelola Hasil Deteksi Stunting</a>
        <a href="{{ route('admin.pengguna.index') }}">Kelola Akun Pengguna</a>
        <a href="{{ route('admin.artikel.index') }}">Kelola Artikel</a>

        <?php if (isset($_SESSION['username'])): ?>
            <div class="user-dropdown">
            <button class="btn btn-secondary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
            <?= $_SESSION['username']; ?> ▼
            </button>
                <div class="dropdown-content">
                    <a href="edit_profil.php">Profiles</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login/index.php" class="btn btn-secondary">Login</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container mt-4">
<div class="table-container">
    <br><br><br>
    <h2 class="big-title" style="color: white;">Riwayat Deteksi Pengguna</h2><br>
    <table class="table table-bordered shadow">
        <thead class="table-dark">
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
            @csrf
            @method('PUT')
                
                <td>{{ $hasilDeteksi->id }}</td>
                <td>{{ $hasilDeteksi->nama_lengkap }}</td>
                <td>{{ $hasilDeteksi->kategori_usia }}</td>
                <td>{{ $hasilDeteksi->kategori_lila }}</td>
                <td>{{ $hasilDeteksi->kategori_tb }}</td>
                <td>{{ $hasilDeteksi->kategori_anak }}</td>
                <td>{{ $hasilDeteksi->kategori_ttd }}</td>
                <td>{{ $hasilDeteksi->kategori_anc }}</td>
                <td>{{ $hasilDeteksi->kategori_td }}</td>
                <td>{{ $hasilDeteksi->kategori_hb }}</td>
                <td>{{ $hasilDeteksi->hasil_deteksi }}</td>
                <td>{{ $hasilDeteksi->created_at }}</td>
                
        </tbody>
    </table>

    <a href="{{ route('admin.hasilDeteksi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
</div><br><br><br><br>
<footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">WSIT Official Reserved - 2025</p>
</footer>

</body>
</html>
