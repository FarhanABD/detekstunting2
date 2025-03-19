{{-- <?php
session_start();
include '../config.php'; // Pastikan file config.php berisi koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil user ID dari sesi login

$query = "SELECT * FROM riwayat_deteksi WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Deteksi</title>
    <style>
        .table {
    background-color: rgba(255, 255, 255, 0.2); /* Transparansi lebih jelas */
    border-radius: 10px; /* Efek rounded */
    overflow: hidden; /* Agar radius berlaku pada seluruh tabel */
}

.table th {
    background-color: #343a40 !important; /* Warna header lebih gelap */
    color: white !important;
    text-align: center;
}

.table td, .table th {
    padding: 12px; /* Jarak lebih nyaman */
    text-align: center;
    vertical-align: middle;
}

.table img {
    border-radius: 8px; /* Gambar juga rounded */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2); /* Efek bayangan */
}

.btn {
    border-radius: 5px; /* Tombol lebih smooth */
}
/* Efek fade-in hanya untuk tabel */
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

/* Animasi untuk setiap baris tabel */
.table tbody tr {
    opacity: 0;
    transform: translateY(10px);
    animation: fadeInRow 0.6s ease-out forwards;
    animation-delay: 0.3s;
}

@keyframes fadeInRow {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hindari efek animasi pada header dan footer */
.header,
.footer {
    opacity: 1 !important;
    transform: none !important;
    animation: none !important;
}
    </style>
    <link rel="stylesheet" href="{{ asset('user-style.css') }}">
<script defer src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <!-- HEADER -->
        <header class="header">
    <h1 class="logo">
        <img src="{{ asset('assets/img/logo-01.png') }}">
    </h1>

    <nav class="nav-menu">
        <a href="{{ route('user.dashboard') }}">Beranda</a>
        <a href="{{ route('user.deteksi.index') }}">Deteksi Stunting</a>
        <a href="{{ route('user.deteksi.show', Auth::user()->id) }}">Riwayat Deteksi</a>
        <a href="{{ route('user.dashboard') }}#artikel">Artikel</a>

        @if (Auth::check())
        <div class="user-dropdown">
            <button class="btn btn-secondary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                {{ Auth::user()->username }}  ▼
            </button>
        <div class="dropdown-content">
            <a href="{{ route('user.profile.show', Auth::user()->id) }}">Profile</a>
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
<h2 class="big-title" style="color: white;">Riwayat Deteksi Dini</h2><br>
<div style="margin-bottom: 10px;">
    <form method="GET" action="{{ route('user.deteksi.show', Auth::id()) }}" class="d-flex align-items-center">
        <label for="per_page" class="me-2" style="color: white;">Tampilkan:</label>
        <select name="per_page" id="per_page" class="form-select" style="width: 150px;" onchange="this.form.submit()">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>
</div>

<table class="table table-bordered shadow" style="background-color: rgba(255, 255, 255, 0.2); border-radius: 10px; overflow: hidden;">
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
        @foreach ($hasilRiwayat as $index => $riwayat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $riwayat->nama_lengkap }}</td>
                <td>{{ $riwayat->kategori_usia }}</td>
                <td>{{ $riwayat->kategori_lila }}</td>
                <td>{{ $riwayat->kategori_tb }}</td>
                <td>{{ $riwayat->kategori_anak }}</td>
                <td>{{ $riwayat->kategori_ttd }}</td>
                <td>{{ $riwayat->kategori_anc }}</td>
                <td>{{ $riwayat->kategori_td }}</td>
                <td>{{ $riwayat->kategori_hb }}</td>
                <td><strong>{{ $riwayat->hasil_deteksi }}</strong></td>
                <td>{{ $riwayat->created_at->format('d M Y, H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-3 d-flex justify-content-center">
    @if ($hasilRiwayat->previousPageUrl())
        <a href="{{ $hasilRiwayat->previousPageUrl() }}&per_page={{ request('per_page') }}" 
            class="btn btn-primary me-2">
            ← Sebelumnya
        </a>
    @endif

    @if ($hasilRiwayat->nextPageUrl())
        <a href="{{ $hasilRiwayat->nextPageUrl() }}&per_page={{ request('per_page') }}" 
            class="btn btn-primary">
            Selanjutnya →
        </a>
    @endif
</div>

</div></div><br><br><br>

    <!-- FOOTER -->
    <footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">Wsit Official Reserved - 2025</p>
    </footer>
</body>
</html>
