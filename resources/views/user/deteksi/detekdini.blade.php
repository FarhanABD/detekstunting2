<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Dini</title>
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
    
        .hasil-deteksi {
            background: linear-gradient(to right, #6a7324, #8a7725);
            padding: 15px;
            border-radius: 10px;
            color: white;
        }
    
        .hasil-judul {
            font-size: 20px;
            font-weight: bold;
        }
    
        .hasil-prediksi {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }
    
        .normal {
            color: #28a745;
            /* Hijau */
        }
    
        .stunting {
            color: #dc3545;
            /* Merah */
        }
    
        .hasil-catatan {
            font-size: 12px;
            font-style: italic;
            color: #f1f1f1;
            margin-top: 8px;
        }
    
        .step {
            display: none;
        }
    
        .step.active {
            display: block;
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
    
        .input-container {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Jarak antara input dan kategori */
        }
    
        .kategori {
            font-weight: bold;
            color: orange;
        }
    
        .input-box input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            /* Tambah padding kanan untuk ikon */
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
            right: 15px;
            /* Geser ikon ke kanan */
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #888;
            cursor: pointer;
            /* Biar bisa diklik */
        }
        </style>
    <link rel="stylesheet" href="{{ asset('user-style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header class="header">
        <h1 class="logo">
            <img src="{{ asset('assets/img/logo-01.png') }}">
        </h1>

        <nav class="nav-menu">
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            <a href="">Deteksi Stunting</a>
            <a href="{{ route('user.deteksi.show', Auth::user()->id) }}">Riwayat Deteksi</a>
            <a href="{{ route('user.dashboard')}}#artikel">Artikel</a>

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
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
            @endauth
        </nav>
    </header>

    <section id="main" class="hero">
        <div class="hero-content">
            <p class="top-text">#AYO DETEKSI STUNTING SEKARANG</p>
            <h2 class="big-title">ISI DENGAN SEKSAMA YA</h2>

            @if (session('success'))
            <p style="color: lightgreen;">{{ session('success') }}</p>
            @endif

            <form id="deteksiForm" method="POST" action="{{ route('user.deteksi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-box">
                    <div class="step active">
                        <input type="text" name="nama" value="{{ $user->nama_lengkap }}" required readonly>
                        <input type="text" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" required readonly>
                        <button class="btn btn-danger btn-sm" type="button" onclick="nextStep()">Lanjut</button>
                    </div>
                </div>

                <div class="input-box">
                    <div class="step">
                        <label>HPHT (Hari Pertama Haid Terakhir)</label>
                        <div class="input-container">
                            <input type="date" name="hpht" id="inputHPHT" required oninput="hitungUsia()">
                        </div>
                        <label>Usia Ibu Saat Hamil</label>
                        <div class="input-container">
                            <input type="number" name="usia" id="inputUsia" required readonly>
                            <span class="kategori" id="kategoriUsia"></span>
                        </div>
                        <label>Lingkar Lengan Atas (cm)</label>
                        <div class="input-container">
                            <input type="number" name="lila" required oninput="updateKategori(this, 'kategoriLila')">
                            <span class="kategori" id="kategoriLila"></span>
                        </div>

                        <button class="btn btn-danger btn-sm" style="background-color: red; color: white;" type="button"
                            onclick="prevStep()">Kembali</button>
                        <button class="btn btn-danger btn-sm" type="button" onclick="nextStep()">Lanjut</button>
                    </div>
                </div>

                <div class="input-box">
                    <div class="step">
                        <label>Tinggi Badan Ibu (cm)</label>
                        <div class="input-container">
                            <input type="number" name="tb_ibu" required oninput="updateKategori(this, 'kategoriTB')">
                            <span class="top-text" id="kategoriTB"></span><br>
                        </div>

                        <label>Jumlah Anak</label>
                        <div class="input-container">
                            <input type="number" name="jumlah_anak" required
                                oninput="updateKategori(this, 'kategoriAnak')">
                            <span class="top-text" id="kategoriAnak"></span><br>
                        </div>

                        <label>Jumlah Konsumsi TTD</label>
                        <div class="input-container">
                            <input type="number" name="jumlah_ttd" required
                                oninput="updateKategori(this, 'kategoriTTD')">
                            <span class="top-text" id="kategoriTTD"></span><br>
                        </div>

                        <button class="btn btn-danger btn-sm" style="background-color: red; color: white;" type="button"
                            onclick="prevStep()">Kembali</button>
                        <button class="btn btn-danger btn-sm" type="button" onclick="nextStep()">Lanjut</button>
                    </div>
                </div>

                <div class="input-box">
                    <div class="step">
                        <label>Jumlah Kunjungan ANC</label>
                        <div class="input-container">
                            <input type="number" name="jumlah_anc" required
                                oninput="updateKategori(this, 'kategoriANC')">
                            <span class="top-text" id="kategoriANC"></span><br>
                        </div>

                        <label>Tekanan Darah (misal: 120/80)</label>
                        <div class="input-container">
                            <input type="text" name="tekanan_darah" required oninput="updateKategoriTekananDarah(this)">
                            <span class="top-text" id="kategoriTekananDarah"></span><br>
                        </div>

                        <label>HB Ibu (g/dL)</label>
                        <div class="input-container">
                            <input type="number" step="0.1" name="hb_ibu" required oninput="updateKategoriHB(this)">
                            <span class="top-text" id="kategoriHB"></span><br>
                        </div>
                        <button class="btn btn-danger btn-sm" style="background-color: red; color: white;" type="button"
                            onclick="prevStep()">Kembali</button>
                        <button class="btn btn-danger btn-sm" type="submit">Cek Stunting</button>
                    </div>
                </div>
            </form>
            <br>
            @if (session('hasil_deteksi'))
            @php
                $hasil_prediksi = session('hasil_deteksi');
                $warna = ($hasil_prediksi == "NORMAL") ? "normal" : "stunting";
            @endphp
        
            <div class="hasil-deteksi">
                <h3 class="hasil-judul">Hasil Deteksi Stunting</h3>
                <p><strong>Prediksi Kelahiran Anak Anda:</strong> <span class="{{ $warna }}" style="  font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;">{{ $hasil_prediksi }}</span></p>
                <p class="hasil-catatan">
                    <strong>NB:</strong> <em>Sistem DetekStunting dapat melakukan kesalahan dalam prediksi.</em> 
                    Hasil di atas hanya sebagai analisis awal. Selalu lakukan pemeriksaan kesehatan rutin 
                    selama kehamilan dan kunjungi fasilitas kesehatan jika Anda mengalami masalah kesehatan.
                </p>
            </div>
        @endif
        
      
        
        </div>
        <img src="{{ asset('assets/img/8073548.png') }}" alt="Pumpkin" class="hero-img" style="width: auto; height: auto;">
    </section>

    <footer class="footer">
        <p>Wsit Official Reserved - 2025</p>
    </footer>

    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll(".step");
    
        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle("active", index === step);
            });
        }
    
        function nextStep() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        }
    
        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }
    
        function hitungUsia() {
    let hphtInput = document.getElementById("inputHPHT").value;
    let tanggalLahirStr = "{{ $user->tanggal_lahir }}"; // Ambil tanggal lahir sebagai string
    let kategori = document.getElementById("kategoriUsia");

    if (hphtInput && tanggalLahirStr) {
        let hphtDate = new Date(hphtInput);
        let tanggalLahirParts = tanggalLahirStr.split('-'); // Asumsi format YYYY-MM-DD
        let tanggalLahir = new Date(tanggalLahirParts[0], tanggalLahirParts[1] - 1, tanggalLahirParts[2]); // Buat objek Date

        let usia = hphtDate.getFullYear() - tanggalLahir.getFullYear();

        // Koreksi perhitungan jika bulan/tanggal belum lewat dalam tahun berjalan
        if (
            hphtDate.getMonth() < tanggalLahir.getMonth() ||
            (hphtDate.getMonth() === tanggalLahir.getMonth() && hphtDate.getDate() < tanggalLahir.getDate())
        ) {
            usia--;
        }

        // Tampilkan hasil
        document.getElementById("inputUsia").value = usia;
        kategori.innerText = (usia < 20 || usia > 35) ? "Berisiko" : "Tidak berisiko";
    } else {
        document.getElementById("inputUsia").value = "";
        kategori.innerText = "";
    }
}
        function updateKategori(input, targetId) {
            let value = parseFloat(input.value);
            let kategori = "";
    
            if (targetId === "kategoriLila") {
                kategori = value < 23.3 ? "Berisiko" : "Tidak berisiko";
            } else if (targetId === "kategoriTB") {
                kategori = value < 150 ? "Pendek" : "Tinggi";
            } else if (targetId === "kategoriAnak") {
                kategori = value > 2 ? "Berisiko" : "Tidak berisiko";
            } else if (targetId === "kategoriTTD") {
                kategori = value < 90 ? "Kurang" : "Cukup";
            } else if (targetId === "kategoriANC") {
                kategori = value < 6 ? "Kurang" : "Lengkap";
            }
    
    
            document.getElementById(targetId).innerText = kategori;
        }
    
        function updateKategoriHB(input) {
            let value = parseFloat(input.value);
            let kategori = value < 7 ? "Anemia berat" : value >= 7 && value <= 8 ? "Anemia sedang" : value >= 9 && value <=
                10 ? "Anemia ringan" : "Normal";
            document.getElementById("kategoriHB").innerText = kategori;
        }
    
        function updateKategoriTekananDarah(input) {
            let tekanan = input.value.split("/");
            if (tekanan.length === 2) {
                let sistolik = parseInt(tekanan[0]);
                let diastolik = parseInt(tekanan[1]);
                let kategori = "";
    
                if (sistolik >= 130 || diastolik >= 90) {
                    kategori = "Hipertensi";
                } else if (sistolik <= 100 || diastolik <= 60) {
                    kategori = "Hipotensi";
                } else {
                    kategori = "Normal";
                }
    
                document.getElementById("kategoriTekananDarah").innerText = kategori;
            } else {
                document.getElementById("kategoriTekananDarah").innerText = "";
            }
        }
        </script>
</body>
</html>