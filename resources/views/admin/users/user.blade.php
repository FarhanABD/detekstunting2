{{-- <?php
include '../config.php';
session_start();

// Ambil data user (hanya role 'user')
$query = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($conn, $query);

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    echo "<script>alert('User berhasil dihapus!'); window.location='kelola_user.php';</script>";
}

// Reset password user
if (isset($_GET['reset'])) {
    $id = $_GET['reset'];
    $default_password = password_hash("password123", PASSWORD_BCRYPT); // Password default
    mysqli_query($conn, "UPDATE users SET password='$default_password' WHERE id = $id");
    echo "<script>alert('Password berhasil direset ke password123!'); window.location='kelola_user.php';</script>";
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna</title>
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

.header,
.footer {
    opacity: 1 !important;
    transform: none !important;
    animation: none !important;
}

    </style>
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
    <h2 class="big-title" style="color: white;">Kelola Akun Pengguna</h2>
    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="mb-3">
        <label for="per_page" style="color: white;">Tampilkan:</label>
        <select name="per_page" id="per_page" class="form-select" style="width: 150px;" onchange="this.form.submit()">

            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
        </select>
    </form>
    <!-- Tombol Tambah Artikel -->
    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary mb-3" class="btn btn-secondary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Tambah User</a>
    <table class="table table-bordered shadow" style="background-color: rgba(255, 255, 255, 0.2); border-radius: 10px; overflow: hidden;">
    <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Lahir</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilUser as $user )
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->tanggal_lahir }}</td>
                <td class="d-flex justify-content-center gap-2">
                    <form action="{{ route('admin.pengguna.reset', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm" style="background-color: orange; color: white;" onclick="return confirm('Reset password user ini?')">
                            Reset Password
                        </button>
                    </form>
                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
</body>
</html>
