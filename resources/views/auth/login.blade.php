<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMANIS Polibatam</title>
    <link rel="icon" href="{{ asset('images/polibatam.png') }}" type="image/png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (untuk ikon mata) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    {{-- Landing Page CSS --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-card text-center">
        <div class="login-logo">
            <img src="{{ asset('images/polibatam.png') }}" alt="Polibatam Logo">
        </div>
        <h5 class="fw-bold mb-3">Sistem Manajemen Risiko<br>Politeknik Negeri Batam</h5>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Masukkan nama pengguna anda" name="username"
                    required>
            </div>

            <!-- Input Password + Toggle Eye -->
            <div class="mb-3 password-wrapper">
                <input type="password" class="form-control" placeholder="Masukkan kata sandi anda" name="password"
                    id="password" required>
                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
            </div>

            <p class="small-text">
                Masuk dengan Dokpol / Gunakan NIK dan password web untuk masuk menggunakan akun lokal!
            </p>

            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>

    <!-- Script Toggle Eye pada Password -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Ubah ikon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>

</body>

</html>
