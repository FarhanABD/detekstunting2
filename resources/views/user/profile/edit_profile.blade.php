{{-- <?php
session_start();
include '../config.php'; // Koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$sql = "SELECT username, nama_lengkap, tanggal_lahir, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : NULL;

    // Update data user
    if ($password) {
        $sql = "UPDATE users SET username=?, nama_lengkap=?, tanggal_lahir=?, email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $nama_lengkap, $tanggal_lahir, $email, $password, $user_id);
    } else {
        $sql = "UPDATE users SET username=?, nama_lengkap=?, tanggal_lahir=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $nama_lengkap, $tanggal_lahir, $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profil berhasil diperbarui!";
        header("Location: edit_profil.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan, coba lagi!";
    }
}
?> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #3d4917, #b8860b);
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            background: orange;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: darkorange;
        }
        .input-box {
        position: relative;
        width: 600px;
    }

    .input-box input {
        width: 100%;
        padding: 12px 45px 12px 15px; /* Tambah padding kanan untuk ikon */
        background: #fff;
        border-radius: 8px;
        border: none;
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
    cursor: pointer; /* Biar bisa diklik */
}
    </style>
        <link rel="stylesheet" href="{{ asset('user-style.css') }}">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        <a href="{{ route('user.deteksi.show', Auth::user()->id) }}') }}">Riwayat Deteksi</a>
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
            @endauth
    </nav>
</header>



    <!-- HERO SECTION -->
    <section id="main" class="hero">
        <div class="hero-content">
            <p class="top-text">#PASTIKAN DATA MU SUDAH BENAR YA</p>
            <h2 class="big-title">EDIT PROFIL</h2>
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color:lightgreen;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <p style="color:red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <form method="POST" action="{{ route('user.profile.update', Auth::user()->id) }}" enctype="multipart/form-data">
                @csrf
            <div class="input-box">
                <i class='bx bxs-user'></i>
                <input type="text" name="username" value="{{ $user->username }}" required>
            </div>
            <div class="input-box">
        <i class='bx bxs-user-detail'></i>
        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
    </div>
    <div class="input-box">
        <i class='bx bxs-calendar'></i>
        <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" required>
    </div>
    <div class="input-box">
        <i class='bx bxs-envelope'></i>
        <input type="email" name="email" value="{{ $user->email }}" placeholder="Email (Opsional)">
    </div>
    <div class="input-box">
    <i class='bx bx-hide' id="togglePassword"></i> <!-- ID Sesuai -->
    <input type="password" name="password" value="{{ $user->password }}" id="passwordInput" placeholder="Password Baru (Opsional)">
</div>


            <div class="buttons">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
            </form>
        </div>
        <img src="{{ asset('assets/img/cuteprofileadmin.png') }}" alt="Pumpkin" class="hero-img" style="width: auto; height: auto;">

    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <p>Wsit Official Reserved - 2025</p>
    </footer>

    <script>
document.getElementById("togglePassword").addEventListener("click", function () {
    let passwordInput = document.getElementById("passwordInput");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        this.classList.replace("bx-hide", "bx-show"); // Ganti ikon ke show
    } else {
        passwordInput.type = "password";
        this.classList.replace("bx-show", "bx-hide"); // Ganti ikon ke hide
    }
});

        </script>
</body>
</html>
