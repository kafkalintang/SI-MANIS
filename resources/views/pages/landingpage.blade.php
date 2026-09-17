@extends('layouts.landingpage')

@section('title', 'Sistem Manajemen Risiko Polibatam')

@section('content')

    <section class="hero d-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('images/simanis_putih.png') }}" alt="SiMANiS" class="img-fluid mb-0" style="max-width: 535px;">
        <h4 class="fw-bold mb-0" style="margin-top: -15px; font-size: 29px;">Sistem Manajemen Risiko Polibatam</h4>
        <p class="lead mt-9 text-center"
            style="font-family: 'Poppins', sans-serif; font-size: 20px; max-width: 700px; line-height: 1.6;">
            Platform terpadu untuk registrasi, penilaian, mitigasi,<br> dan pemantauan risiko di Polibatam.
        </p>
    </section>


    <!-- Section Tentang Kami -->
    <section id="tentang" class="py-5" style="background-color: #1E376C; color: white;">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Tentang Kami</h2>
            <p class="mx-auto" style="max-width: 800px; font-size: 16px; line-height: 1.8;">
                Aplikasi Manajemen Risiko Polibatam merupakan sistem digital yang dirancang untuk mendukung tata kelola
                risiko agar lebih efektif, transparan, dan terintegrasi.
                <br><br>
                Melalui aplikasi ini, seluruh tahapan manajemen risiko dapat dilakukan secara menyeluruh, mulai dari
                registrasi isu dan risiko, penilaian, visualisasi dalam bentuk matriks, tindak lanjut rencana aksi mitigasi,
                pemantauan, pelaporan, hingga audit kepatuhan.
                <br><br>
                Sistem ini hadir untuk menggantikan metode manual berbasis Excel dan OneDrive, sehingga pengelolaan data
                risiko menjadi lebih real-time, efisien, dan terdokumentasi dengan baik. Selain itu, aplikasi juga mendukung
                integrasi dengan E-SPMI sebagai bagian dari sistem tata kelola organisasi di Polibatam.
            </p>
        </div>
    </section>
    

    <!-- Section Kontak -->
    <div class="wrapper-kontak" style="position:relative; margin:0;">

        <section id="card-oren" style="background-color:#F2682A; border-radius:85px 85px 0 0; margin:0; height:300px;">
        </section>
        <section id="card-biru" style="background-color:#57C9E8; border-radius:78px 78px 0 0; margin:0; height:300px;">
        </section>
        <section id="kontak" style="background-color:white; border-radius:69px 69px 0 0; margin:0; height:300px;
                       display:flex; align-items:center;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-md-4 offset-md-1" style="margin-left: -70px;">
                        <img src="{{ asset('images/simanis.png') }}" alt="SIMANIS Logo" class="img-fluid mb-2"
                            style="max-width: 400px;">
                        <p class="text-muted mb-0" style="font-size: 14px;">Proyek PBL Teknik Informatika Polibatam</p>
                    </div>

                    <!-- Google Maps -->
                    <div class="col-md-4 offset-md-1 mb-4 mb-md-0 text-center">
                        <a href="https://www.google.com/maps?q=1.118978,104.048392&z=17" target="_blank">
                            <div class="ratio ratio-1x1 overflow-hidden map-container"
                                style="max-width: 230px; margin: 0 auto; cursor: pointer;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3989.0741!2d104.048392!3d1.118978!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMS4xMTg5NzgsMTA0LjA0ODM5Mg!5e0!3m2!1sid!2sid!4v1697XXXXX!5m2!1sid!2sid"
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </a>
                    </div>

                    <!-- Kontak -->
                    <div class="col-md-4 offset-md-1" style="margin-left: -60px;">
                        <div class="mb-3 contact-box shadow-sm">
                            <i class="fa-solid fa-phone fs-5 me-3"></i>
                            <span>+62 778 4698 4698 ext. 1036</span>
                        </div>

                        <div class="mb-3 contact-box shadow-sm">
                            <i class="fa-solid fa-envelope fs-5 me-3"></i>
                            <span>p4m@polibatam.ac.id</span>
                        </div>

                        <div class="align-items-start rounded mb-3 contact-box shadow-sm"
                            style="background-color: #D9D9D9;">
                            <i class="fa-solid fa-location-dot fs-5 me-3 mt-1"></i>
                            <span>
                                Lantai 3 Gedung Utama, Jalan Ahmad Yani, Tlk. Tering<br>
                                Kec. Batam Kota, Kota Batam<br>
                                Kepulauan Riau 29461
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection