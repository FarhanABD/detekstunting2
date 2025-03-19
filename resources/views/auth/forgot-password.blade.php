{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('style-login.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<header class="header">
    <h1 class="logo1">
    {{-- <img src="logo-01.png"> --}}
</h1>
        {{-- <nav class="nav-menu">
            <a href="../index.php">Beranda</a>
            <a href="#">Deteksi Stunting</a>
            <a href="../index.php#artikel">Artikel</a>
        </nav> --}}
    </header>

    <section class="hero">
    <div class="container">
    <div class="form-box login">
        <form action="update_password.php" method="POST">
            <h1>Reset Password</h1>
            <div class="input-box">
                <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
    <input type="password" name="password_baru" id="resetPassword" placeholder="Masukkan Password Baru" required>
    <i class='bx bx-hide' id="toggleResetPassword"></i> <!-- Pastikan ID unik -->
</div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
    <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <img src="{{ asset('assets/img/logo-01.png') }}" alt="Logo" class="logo">
                <h1>Selamat Datang</h1>
                <p>Silahkan reset password Anda dan login kembali</p>
                <button class="btn register-btn" onclick="window.location.href='{{ route('admin.auth.login') }}'">Kembali</button>

            </div></div>
            </section>
                    <!-- FOOTER -->
        <footer class="footer">
        <p>Wsit Official Reserved - 2025</p>
    </footer>

            <script  src="login.js"></script>
            <script>
                // Toggle password visibility for reset password form
const toggleResetPassword = document.getElementById("toggleResetPassword");
const resetPasswordInput = document.getElementById("resetPassword");

if (toggleResetPassword && resetPasswordInput) {
    toggleResetPassword.addEventListener("click", function () {
        const type = resetPasswordInput.getAttribute("type") === "password" ? "text" : "password";
        resetPasswordInput.setAttribute("type", type);
        toggleResetPassword.classList.toggle("bx-hide");
        toggleResetPassword.classList.toggle("bx-show");
    });
}
            </script>
</body>
</html>

