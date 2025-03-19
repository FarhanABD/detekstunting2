{{-- <?php
include '../config.php';
session_start();

// Ambil semua user dan data deteksi terbaru jika ada
$query = "SELECT u.id AS user_id, u.nama_lengkap, 
                 COALESCE(r.usia, '-') AS usia, 
                 COALESCE(r.lila, '-') AS lila, 
                 COALESCE(r.tb_ibu, '-') AS tb_ibu, 
                 COALESCE(r.jumlah_anak, '-') AS jumlah_anak, 
                 COALESCE(r.hasil_deteksi, '-') AS hasil_deteksi, 
                 COALESCE(r.created_at, '-') AS created_at
          FROM users u
          LEFT JOIN (
              SELECT r1.* FROM riwayat_deteksi r1
              JOIN (SELECT user_id, MAX(created_at) AS max_date FROM riwayat_deteksi GROUP BY user_id) r2
              ON r1.user_id = r2.user_id AND r1.created_at = r2.max_date
          ) r ON u.id = r.user_id
          WHERE u.role = 'user'
          ORDER BY r.created_at DESC";

$result = $conn->query($query);
?>  --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Hasil Deteksi</title>
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

        .btn {
            border-radius: 5px;
            padding: 8px 12px;
            text-decoration: none;
        }

        .btn-detail {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-detail:hover {
            background-color: darkblue;
        }

        .table-container {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeInTable 0.8s ease-out forwards;
            animation-delay: 0.2s;
        }

        @keyframes fadeInTable {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
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

        @if (Auth::check())
            <div class="user-dropdown">
                <button class="btn btn-secondary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                    {{ Auth::user()->username }}  ▼
                </button>
            <div class="dropdown-content">
                <a href="{{ route('admin.profile.show', Auth::user()->id) }}">Profile</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            </div>
            @else
            <a href="login/index.php" class="btn btn-secondary">Login</a>
        @endif
    </nav>
</header>

<div class="container mt-4">
    <div class="table-container">
    <br><br><br>
    <h2 class="big-title" style="color: white;">Kelola Riwayat Deteksi Pengguna</h2><br>
    <form method="GET" action="{{ route('admin.hasilDeteksi.index') }}" class="mb-3">
        <label for="per_page" style="color: white;">Tampilkan:</label>
        <select name="per_page" id="per_page" class="form-select" style="width: 150px;" onchange="this.form.submit()">

            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>
    <table class="table table-bordered shadow">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Usia</th>
                <th>LILA</th>
                <th>TB Ibu</th>
                <th>Jumlah Anak</th>
                <th>Hasil Deteksi</th>
                <th>Tanggal Deteksi</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilDeteksi as $riwayat)
            <tr>
                <td>{{ $riwayat->id }}</td>
                <td>{{ $riwayat->nama_lengkap }}</td>
                <td>{{ $riwayat->usia }}</td>
                <td>{{ $riwayat->lila }}</td>
                <td>{{ $riwayat->tb_ibu }}</td>
                <td>{{ $riwayat->jumlah_anak }}</td>
                <td>{{ $riwayat->hasil_deteksi }}</td>
                <td>{{ $riwayat->created_at }}</td>
                <td>
                    <a href="{{ route('admin.hasilDeteksi.show', $riwayat->user_id) }}" class="btn btn-primary btn-sm">
                        Lihat Riwayat
                    </a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
        
    </table>

    <!-- Navigasi Pagination -->
<div class="d-flex justify-content-center">
    {{ $hasilDeteksi->appends(['per_page' => $perPage])->links() }}
</div>

    </div>
</div>

<footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">WSIT Official Reserved - 2025</p>
</footer>

</body>
</html>
