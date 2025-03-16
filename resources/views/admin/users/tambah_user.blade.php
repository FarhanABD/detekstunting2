{{-- <?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email = !empty($_POST['email']) ? $_POST['email'] : NULL; // Email opsional
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    
    $sql = "INSERT INTO users (username, nama_lengkap, tanggal_lahir, email,  password, role) 
            VALUES ('$username', '$nama_lengkap', '$tanggal_lahir', '$email', '$password', 'user')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location='kelola_user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user!');</script>";
    }
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style-dashboard-admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
.input-box {
    position: relative;
    width: 600px;
    margin-bottom: 20px; /* Menambahkan jarak antar input */
}

.input-box input {
    width: 100%;
    padding: 12px 45px 12px 15px; /* Tambah padding kanan untuk ikon */
    background: #fff;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 16px;
    color: #333;
    font-weight: 500;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.input-box i {
    position: absolute;
    right: 15px; /* Geser ikon ke kanan */
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #888;
    cursor: pointer;
}

/* Mengubah tampilan input tanggal agar placeholder terlihat */
.input-box input[type="date"] {
    color: #999;
}

.input-box input[type="date"]:focus {
    color: #333;
}

        </style>
    <script defer src="script.js"></script>
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
<section id="main" class="hero">
        <div class="hero-content">
            <h2 class="big-title">Tambah User</h2>
            <form method="POST" action="{{ route('admin.pengguna.store') }}" enctype="multipart/form-data">
                @csrf
    <div class="input-box">
        <i class='bx bxs-user'></i>
        <input type="text" name="username" placeholder="Username" class="form-control" required>
    </div>
    <div class="input-box">
        <i class='bx bxs-user-detail'></i>
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" required>
    </div>
    <div class="input-box">
        <i class='bx bxs-envelope'></i>
        <input type="email" name="email" placeholder="Email (Opsional)" class="form-control">
    </div>
    <div class="input-box">
        <i class='bx bxs-calendar'></i>
        <input type="date" name="tanggal_lahir" class="form-control" required>
    </div>
    <div class="input-box">
        <i class='bx bx-hide' id="toggleRegisterPassword"></i>
        <input type="password" name="password" id="registerPassword" placeholder="Password" class="form-control" required>
    </div>
    <button type="submit" class="btn" style="background-color: orange; color: white;">Tambah</button>
    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Batal</a>
</form>

</div>

</section>
    <!-- FOOTER -->
    <footer class="footer">
        <p>Wsit Official Reserved - 2025</p>
    </footer>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Toggle password visibility for registration form
    const toggleRegisterPassword = document.getElementById("toggleRegisterPassword");
    const registerPasswordInput = document.getElementById("registerPassword");

    if (toggleRegisterPassword && registerPasswordInput) {
        toggleRegisterPassword.addEventListener("click", function () {
            const type = registerPasswordInput.getAttribute("type") === "password" ? "text" : "password";
            registerPasswordInput.setAttribute("type", type);
            toggleRegisterPassword.classList.toggle("bx-hide");
            toggleRegisterPassword.classList.toggle("bx-show");
        });
    }
});
        </script>
</body>
</html>
