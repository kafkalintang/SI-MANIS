  {{-- Navbar Landing Page CSS --}}
  <link rel="stylesheet" href="{{ asset('css/navbar_landing_page.css') }}">

  <nav class="navbar navbar-expand-lg bg-light shadow-sm fixed-top">
      <div class="container-fluid px-4 d-flex align-items-center justify-content-between">

          <!-- Logo kiri -->
          <a class="navbar-brand d-flex align-items-center" href="#">
              <img src="{{ asset('images/polibatam.png') }}" alt="Polibatam" width="40" height="40" class="me-3">
              <img src="{{ asset('images/simanis.png') }}" alt="SiMANiS" width="125" height="35">
          </a>

          <!-- Toggler (muncul di mobile) -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
              style="border: none; box-shadow: none; background: transparent;">
              <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Menu Tengah -->
          <div class="collapse navbar-collapse position-absolute start-50 translate-middle-x text-center"
              id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item mx-4">
                      <a class="nav-link fw-medium" href="#" style="color: #000;">Beranda</a>
                  </li>
                  <li class="nav-item mx-4">
                      <a class="nav-link fw-medium" href="#tentang" style="color: #000;">Tentang Kami</a>
                  </li>
                  <li class="nav-item mx-4">
                      <a class="nav-link fw-medium" href="#kontak" style="color: #000;">Kontak</a>
                  </li>
                  <!-- Tombol Masuk pindah ke sini -->
                  <li class="nav-item mx-4 d-lg-none">
                      <a class="btn btn-primary px-3 py-1 w-100" href="/login">Masuk</a>
                  </li>
              </ul>
          </div>

          <!-- Tombol Masuk Kanan -->
          <div class="d-none d-lg-flex align-items-center ms-auto">
              <a class="btn btn-primary " href="/login">Masuk</a>
          </div>
      </div>
  </nav>
