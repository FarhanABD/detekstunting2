{{-- <?php
include '../config.php';

session_start();

$id = $_GET['id'];
$query = "SELECT * FROM artikel WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    // Jika ada gambar baru diupload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../images/" . $gambar);
        $sql = "UPDATE artikel SET judul='$judul', gambar='$gambar', deskripsi='$deskripsi' WHERE id=$id";
    } else {
        $sql = "UPDATE artikel SET judul='$judul', deskripsi='$deskripsi' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Artikel berhasil diperbarui!'); window.location='kelola_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit artikel!');</script>";
    }
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
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
/* Hanya halaman utama yang memiliki efek fade-in */
body {
    opacity: 1; /* Set default agar tidak terpengaruh */
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
        <a href="{{ route('admin.dashboard') }}">Beranda</a>
        <a href="kelola_hasildetek.php">Kelola Hasil Deteksi Stunting</a>
        <a href="kelola_user.php">Kelola Akun Pengguna</a>
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


<main class="artikel-container">
<div class="container mt-4">
    <h2 class="big-title" style="color: orange; font-family: 'Poppins', sans-serif;">Edit Artikel</h2>
    <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $artikel->judul }}" required>
        </div>
    
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Gambar</label>
            <input type="file" name="gambar" class="form-control">
            @if ($artikel->gambar)
                <img src="{{ asset('storage/images/' . $artikel->gambar) }}" width="100">
            @endif
        </div>
    
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $artikel->deskripsi }}</textarea>
        </div>
    
        <div class="mb-3">
            <label style="color: white; font-family: 'Poppins', sans-serif;">Tanggal Terbit</label>
            <input type="date" name="tanggal" value="{{ $artikel->tanggal }}" class="form-control" required>
        </div>
    
        <button type="submit" class="btn" style="background-color: orange; color: white;">Simpan</button>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">Batal</a>
    </form>
    
</div>
</main><br><br>

    <!-- FOOTER -->
    <footer class="footer">
    <p style="color: white; font-family: 'Poppins', sans-serif;">Wsit Official Reserved - 2025</p>
    </footer>

</body>
</html>
