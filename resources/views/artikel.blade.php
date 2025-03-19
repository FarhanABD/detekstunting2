{{-- <?php
include '../config.php';

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM artikel WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan.";
        exit;
    }
} else {
    echo "ID artikel tidak diberikan.";
    exit;
}

// Ambil data artikel dari database
$sql = "SELECT * FROM artikel ORDER BY tanggal DESC";
$result = $conn->query($sql);
?> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halloween</title>
    <link rel="stylesheet" href="{{ asset('user-style.css') }}">
    <script defer src="{{ asset('user-script.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css">
    <style>
        .artikel-container {
    max-width: 92%;
    margin: 100px auto 50px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.artikel-judul {
    font-size: 32px;
    font-weight: bold;
    color: orange;
}

.artikel-tanggal {
    font-size: 14px;
    color: lightgray;
}

.artikel-gambar {
    width: 50%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 10px;
    margin: 20px 0;
}

.artikel-isi {
    font-size: 18px;
    line-height: 1.6;
    text-align: justify;
}

.btn-kembali {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: orange;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.btn-kembali:hover {
    background: darkorange;
}

</style>
        </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
    <h1 class="logo">
        <img src="{{ asset('assets/img/logo-01.png') }}">
    </h1>

    <nav class="nav-menu">
            <a href="{{ route('dashboard') }}">Beranda</a>
            <a href="{{ route('admin.auth.login') }}">Deteksi Stunting</a>
            <a href="{{ route('dashboard') }}">Artikel</a>
            <a href="{{ route('admin.auth.login') }}" class="btn btn-secondary">Login</a>
        </nav>
</header>

    <!-- HERO SECTION -->
    <section id="artikel" class="scrollable-section">
        <main class="artikel-container">
        <h1 class="artikel-judul">{{ $artikel->judul }}</h1>
        <p class="artikel-tanggal">Dipublikasikan pada: {{ $artikel->tanggal }}</p>
        <img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}"  class="artikel-gambar">
        <article class="artikel-isi">
        <?php
        $paragraf = explode('.',  $artikel->deskripsi); // Pisahkan berdasarkan titik
        $output = '';
        foreach ($paragraf as $index => $kalimat) {
            if (!empty(trim($kalimat))) {
                $output .= trim($kalimat) . '. '; // Tambahkan titik kembali
            }
            if (($index + 1) % 3 == 0) {
                echo "<p>$output</p>";
                $output = '';
            }
        }
        if (!empty($output)) {
            echo "<p>$output</p>"; // Cetak sisa paragraf jika ada
        }
        ?>
    </article>
    </main>
    <h2 class="section-title">Artikel tentang Stunting</h2><br>
        <div class="scroll-wrapper">
            <div class="scroll-container">
                @foreach ($berita as $artikel )
                <div class="scroll-item">
                    <a href="{{ route('artikel.showUnlogin', $artikel->id) }}">
                        <img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}">
                            <p>{{ $artikel->judul }}</p>
                            <span>{{ Str::limit($artikel->deskripsi, 100) }}...</span>
                        </a>
                    </div>
                @endforeach
               
            </div>
        </div>
        <br><br><br><br>
    </section>
    <!-- FOOTER -->
    <footer class="footer">
        <p>Wsit Official Reserved - 2025</p>
    </footer>


    <script>
document.addEventListener("DOMContentLoaded", function () {
    const scrollContainer = document.querySelector(".scroll-container");
    let intervalTime = 2000; // Geser setiap 2 detik

    function slide() {
        let firstItem = scrollContainer.firstElementChild; // Ambil elemen pertama

        scrollContainer.style.transition = "transform 0.5s ease-in-out";
        scrollContainer.style.transform = `translateX(-230px)`; // Geser ke kiri

        setTimeout(() => {
            scrollContainer.style.transition = "none"; // Matikan animasi sejenak
            scrollContainer.appendChild(firstItem); // Pindahkan elemen pertama ke akhir
            scrollContainer.style.transform = "translateX(0)"; // Reset posisi
        }, 500); // Setelah animasi selesai
    }

    setInterval(slide, intervalTime);
});

    document.addEventListener("DOMContentLoaded", function () {
        let scrollSection = document.querySelector(".scrollable-section");
        let scrollItems = document.querySelectorAll(".scroll-item");

        function checkScroll() {
            let sectionTop = scrollSection.getBoundingClientRect().top;
            let windowHeight = window.innerHeight;

            if (sectionTop < windowHeight - 100) {
                scrollSection.classList.add("show");
                scrollItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add("show");
                    }, index * 200); // Animasi satu per satu dengan delay
                });
                window.removeEventListener("scroll", checkScroll);
            }
        }

        window.addEventListener("scroll", checkScroll);
        checkScroll(); // Cek saat halaman pertama kali dibuka
    });
</script>

</body>
</html>
