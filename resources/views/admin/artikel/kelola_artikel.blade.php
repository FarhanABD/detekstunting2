{{-- <?php
include '../config.php'; 

session_start();
$query = "SELECT * FROM artikel ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM artikel WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Artikel berhasil dihapus!'); window.location='kelola_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus artikel!');</script>";
    }
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel</title>
    <link rel="stylesheet" href="{{ asset('style-dashboard-admin.css') }}">
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
    <script defer src="{{ asset('js-dashboard-admin.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <!-- HEADER -->
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
    <h2 class="big-title" style="color: white;">Kelola Artikel</h2>
    
    <!-- Tombol Tambah Artikel -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
            Tambah Artikel
        </a>
    
        <form method="GET" action="{{ route('admin.artikel.index') }}" class="d-flex align-items-center">
            <label for="per_page" class="me-2" style="color: white;">Tampilkan:</label>
            <select name="per_page" id="per_page" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>
        </form>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilArtikel as $artikel)    
            <tr>
                <td>{{ $artikel->id }}</td>
                <td>{{ $artikel->judul }}</td>
                <td><img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}" width="80">
                </td>
                {{-- <td><img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}" width="80"> --}}
                </td>
                <td>{{ Str::limit($artikel->deskripsi, 50, '...') }}</td>
                <td>{{ $artikel->tanggal }}</td>
                <td>
                    <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="btn btn-primary btn-sm">Buka</a>
                    <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Form untuk hapus dengan metode DELETE -->
                    <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div><br><br><br>

    <!-- FOOTER -->
    <footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">Wsit Official Reserved - 2025</p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
