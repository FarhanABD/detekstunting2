{{-- <?php
include '../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    
    $target = "../images/" . basename($gambar);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $target);

    $sql = "INSERT INTO artikel (judul, gambar, deskripsi, tanggal) VALUES ('$judul', '$gambar', '$deskripsi', NOW())";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Artikel berhasil ditambahkan!'); window.location='kelola_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah artikel!');</script>";
    }
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Artikel</title>
    <link rel="stylesheet" href="{{ asset('style-dashboard-admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
                .artikel-container {
    max-width: 92%;
    margin: 100px auto 50px;
    padding: 20px;
    background: rgba(0, 0, 0, 0);
    border-radius: 10px;
}
textarea.form-control {
    height: 350px; /* Atur tinggi sesuai keinginan */
    resize: vertical; /* Bisa diubah ukurannya secara vertikal */
}
/* Hanya artikel-container yang mendapatkan efek */
.artikel-container {
    opacity: 0;
    transform: translateY(15px);
    animation: fadeInForm 0.8s ease-out forwards;
    animation-delay: 0.2s;
}

@keyframes fadeInForm {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form input box tetap mendapatkan efek */
.input-box {
    opacity: 0;
    transform: translateY(10px);
    animation: fadeInInput 0.8s ease-out forwards;
    animation-delay: 0.4s;
}

@keyframes fadeInInput {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hindari animasi pada header dan footer */
.header,
.footer {
    opacity: 1 !important;
    transform: none !important;
    animation: none !important;
}
    </style>
</head>
<body>
        <!-- HEADER -->
        <header class="header">
    <h1 class="logo">
        <img src="{{ asset('assets/img/logo-01.png') }}">
    </h1>

    <nav class="nav-menu">
        <a href="index.php#main">Beranda</a>
        <a href="kelola_hasildetek.php">Kelola Hasil Deteksi Stunting</a>
        <a href="kelola_user.php">Kelola Akun Pengguna</a>
        <a href="kelola_artikel.php">Kelola Artikel</a>

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

<main class="artikel-container">
<div class="container mt-4">
    <h2 class="big-title" style="color: orange; font-family: 'Poppins', sans-serif;">Tambah Artikel</h2>
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.artikel.store') }}">
        @csrf
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Judul Artikel</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Gambar</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Tanggal Terbit</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="kelola_artikel.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</main><br><br>

    <!-- FOOTER -->
    <footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">Wsit Official Reserved - 2025</p>
    </footer>
</body>
</html>
