{{-- <?php
include '../config.php';

session_start();

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
</head>
<body>

    <!-- HEADER -->
    <header class="header">
    <h1 class="logo">
        <img src="{{ asset('assets/img/logo-01.png') }}">
    </h1>

    <nav class="nav-menu">
        <a href="#main">Beranda</a>
        <a href="{{ route('user.deteksi.index') }}">Deteksi Stunting</a>
        <a href="{{ route('user.deteksi.show', Auth::user()->id) }}">Riwayat Deteksi</a>
        <a href="{{ route('user.artikel', ['id' => $berita->id]) }}">Artikel</a>


        @if (Auth::check())
            <div class="user-dropdown">
            <button class="btn btn-secondary" style="background-color: orange; color: white; border: 2px solid orange; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
                {{ Auth::user()->nama_lengkap }} ▼
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



    <!-- HERO SECTION -->
    <section id="main" class="hero">
        @if (Auth::check())
        <div class="hero-content">
            <p class="top-text">#MARI DETEKSI DAN CEGAH STUNTING</p>
            <h2 class="big-title">SELAMAT DATANG <br> Mom    {{ Auth::user()->name }} ▼</h2>
            <p class="desc">Lakukan deteksi Stunting secara cepat untuk mencegah buah hati kita dari ancaman Stunting</p>
            <div class="buttons">
                <a href="detekdini.php" class="btn btn-primary">Deteksi Sekarang</a>
                <a href="#pengertian" class="btn btn-secondary">Pelajari Stunting</a>
            </div>
        </div>
        @endif
        <img src="{{ asset('assets/img/ibu-01.png') }}" alt="Pumpkin" class="hero-img">
    </section>

    <section id="pengertian" class="hero hidden">
        <div class="hero-content">
            <p class="top-text">SIAPA YANG TAU APA SI ITU</p>
            <h2 class="big-title">STUNTING?</h2>
            <p class="desc">Stunting adalah kondisi di mana tinggi badan anak 
                lebih rendah dari standar usianya, yang merupakan indikasi kekurangan 
                gizi kronis dan gangguan pertumbuhan. Kondisi ini umumnya terjadi akibat
                 malnutrisi yang berkepanjangan, infeksi berulang, dan kurangnya stimulasi 
                 yang memadai pada masa awal kehidupan.</p>

            <p class="desc">
            Di Indonesia, stunting merupakan masalah kesehatan yang signifikan. 
            Menurut data Survei Status Gizi Indonesia (SSGI) 2022, prevalensi stunting 
            masih berada pada angka yang cukup tinggi, meskipun telah terjadi penurunan dalam 
            beberapa tahun terakhir. Pemerintah Indonesia telah menargetkan penurunan prevalensi 
            stunting menjadi 14% pada tahun 2024 melalui berbagai intervensi, seperti perbaikan 
            akses terhadap gizi, sanitasi, dan layanan kesehatan ibu dan anak.</p>
        </div>
        <img src="{{ asset('assets/img/anak 2-01.png') }}" alt="Pumpkin" style="max-width: 400px; animation: slideIn 1s ease-in-out;">
    </section>

    <section id="artikel" class="scrollable-section">
    <h2 class="section-title">Artikel tentang Stunting</h2>
    <div class="scroll-wrapper">
        <div class="scroll-container">
            @foreach ($artikels as $news )
            <div class="scroll-item">
               <a href="">
                   <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}">
                   <p>{{ $news->judul }}</p>
                   <span>{{ Str::limit($news->deskripsi, 100) }}...</span>
               </a>
           </div>
            @endforeach    
        </div>
    </div>
</section> <br><br><br><br><br><br>

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
    let elements = document.querySelectorAll(".hidden");

    function checkScroll() {
        elements.forEach((element) => {
            let position = element.getBoundingClientRect().top;
            let screenHeight = window.innerHeight;

            if (position < screenHeight - 100) {
                element.classList.add("show");
            }
        });
    }

    window.addEventListener("scroll", checkScroll);
    checkScroll(); // Cek saat halaman pertama kali dimuat
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
