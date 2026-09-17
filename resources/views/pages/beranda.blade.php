@extends('layouts.pengguna')
@section('title', 'Beranda')

@section('content')
    {{-- Beranda CSS --}}
    <link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <div class="container-fluid">
        <h3 class="mt-3 mb-4">Beranda</h3>

        @if (auth()->user()->hasAnyRole(['p4m']))
            <!-- REPORT REGISTRASI -->
            <div class="card p-4 mb-4" style="border: 1px solid #E5E7EB; box-shadow: 0 6px 14px rgba(0,0,0,0.10);">

                <!-- DROPDOWN TAHUN REGISTRASI -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" action="{{ route('beranda') }}">
                        <select name="tahun_registrasi" class="form-select form-select-sm" style="width: 150px;"
                            onchange="this.form.submit()">
                            @foreach ($daftarTahunRegistrasi as $t)
                                <option value="{{ $t }}" {{ $tahunRegistrasi == $t ? 'selected' : '' }}>
                                    Tahun {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="row">
                    <!-- UNIT SUDAH MENGISI -->
                    <div class="col-md-6 mb-3">
                        <div class="card p-3 h-100" style="border: 1px solid #E5E7EB; box-shadow: 0 3px 8px rgba(0,0,0,0.08);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Unit yang Telah Mengisi Registrasi</h6>
                                <span class="fs-4" style="color: #4194cb;">
                                    <i class="bi-emoji-smile-fill"></i>
                                </span>
                            </div>
                            <h2 class="mt-2 mb-3 fw-bold" style="color: #4194cb;">{{ $jumlahSudahIsi }}</h2>
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-sm dropdown-toggle d-flex justify-content-between align-items-center"
                                    data-bs-toggle="dropdown" data-bs-auto-close="inside"
                                    style="background-color: #4194cb; color: white; width: 100%;">
                                    <span>Lihat Daftar Unit</span>
                                </button>
                                <ul class="dropdown-menu" style="width: 100%; max-height: 200px; overflow-y: auto;">
                                    @forelse ($unitsSudahIsi as $u)
                                        <li><span class="dropdown-item-text">{{ $u->nama_unit }}</span></li>
                                    @empty
                                        <li><span class="dropdown-item-text text-muted">Tidak ada</span></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- UNIT BELUM MENGISI -->
                    <div class="col-md-6 mb-3">
                        <div class="card p-3 h-100" style="border: 1px solid #E5E7EB; box-shadow: 0 3px 8px rgba(0,0,0,0.08);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Unit yang Belum Mengisi Registrasi</h6>
                                <span class="fs-4" style="color: #7f7f7f;">
                                    <i class="bi-emoji-frown-fill"></i>
                                </span>
                            </div>
                            <h2 class="mt-2 mb-3 fw-bold" style="color: #7f7f7f;">{{ $jumlahBelumIsi }}</h2>
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-sm dropdown-toggle d-flex justify-content-between align-items-center"
                                    data-bs-toggle="dropdown" data-bs-auto-close="inside"
                                    style="background-color: #7f7f7f; color: white; width: 100%;">
                                    <span>Lihat Daftar Unit</span>
                                </button>
                                <ul class="dropdown-menu" style="width: 100%; max-height: 400px; overflow-y: auto;">
                                    @forelse ($unitsBelumIsi as $u)
                                        <li><span class="dropdown-item-text">{{ $u->nama_unit }}</span></li>
                                    @empty
                                        <li><span class="dropdown-item-text text-muted">Semua unit sudah mengisi</span></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- STATUS EVALUASI -->
        <div class="card p-4 mb-4" style="border:1px solid #E5E7EB; box-shadow:0 6px 14px rgba(0,0,0,0.10);">
            <div class="row mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" action="{{ route('beranda') }}">
                        <select class="form-select form-select-sm" name="tahun" style="width: 150px;"
                            onchange="this.form.submit()">
                            @foreach ($daftarTahun as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                    Tahun {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- CLOSED -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3 h-100" style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Status Pelaksanaan Evaluasi</h6>
                            <span class="fs-4" style="color:#A6D96A;">
                                <i class="bi bi-check-circle-fill"></i>
                            </span>
                        </div>
                        <h2 class="mt-2 fw-bold" style="color:#A6D96A;">{{ $evaluasi_closed ?? 0 }}</h2>
                        <p class="mb-0">Closed</p>
                    </div>
                </div>

                <!-- MENURUN -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3 h-100" style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Status Pelaksanaan Evaluasi</h6>
                            <span class="fs-4" style="color:#F46D43;">
                                <i class="bi bi-exclamation-circle-fill"></i>
                            </span>
                        </div>
                        <h2 class="mt-2 fw-bold" style="color:#F46D43;">{{ $evaluasi_menurun ?? 0 }}</h2>
                        <p class="mb-0">Open (Menurun)</p>
                    </div>
                </div>

                <!-- MENINGKAT -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3 h-100" style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Status Pelaksanaan Evaluasi</h6>
                            <span class="fs-4" style="color:#DC362E;">
                                <i class="bi bi-x-circle-fill"></i>
                            </span>
                        </div>
                        <h2 class="mt-2 fw-bold" style="color:#DC362E;">{{ $evaluasi_meningkat ?? 0 }}</h2>
                        <p class="mb-0">Open (Meningkat)</p>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- HEATMAP -->
                <div class="col-md-6 mb-3">
                    <div class="card p-3 h-100" style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                        <h6 class="fw-bold mb-3">Heatmap Risiko</h6>
                        <div class="d-flex align-items-start">

                            <!-- TABEL -->
                            <table class="table table-bordered text-center align-middle me-4" style="width:auto;">
                                <thead>
                                    <tr>
                                        <th class="bg-light"></th>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="1. Tidak Signifikan (dampaknya hanya di area tersebut)">1</th>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="2. Kecil (dampaknya sampai satu bagian/departemen)">2</th>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="3. Sedang (dampaknya sampai satu institusi)">3</th>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="4. Besar (akibatnya sampai ke Customer)">4</th>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="5. Bencana (dampaknya sampai ke pemerintah dan atau Customer)">5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="A. Hampir Pasti (beberapa kali tiap peristiwa/ tiap hari terjadi)">A</th>
                                        @for ($col = 1; $col <= 5; $col++)
                                            <td data-row="A" data-col="{{ $col }}" class="heatmap-cell"
                                                style="width:45px;height:45px;cursor:pointer;"></td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="B. Mungkin Sekali (>1 kali tiap bulan)">B</th>
                                        @for ($col = 1; $col <= 5; $col++)
                                            <td data-row="B" data-col="{{ $col }}" class="heatmap-cell"
                                                style="width:45px;height:45px;cursor:pointer;"></td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="C. Mungkin (Dalam Setahun ada 1–5 kali)">C</th>
                                        @for ($col = 1; $col <= 5; $col++)
                                            <td data-row="C" data-col="{{ $col }}" class="heatmap-cell"
                                                style="width:45px;height:45px;cursor:pointer;"></td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="D. Jarang (dalam setahun hanya 1 kali)">D</th>
                                        @for ($col = 1; $col <= 5; $col++)
                                            <td data-row="D" data-col="{{ $col }}" class="heatmap-cell"
                                                style="width:45px;height:45px;cursor:pointer;"></td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th class="bg-light" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="E. Sangat Jarang (hampir tidak pernah terjadi, dalam 5 tahun hanya 1 kali)">
                                            E
                                        </th>
                                        @for ($col = 1; $col <= 5; $col++)
                                            <td data-row="E" data-col="{{ $col }}" class="heatmap-cell"
                                                style="width:45px;height:45px;cursor:pointer;"></td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>

                            <!-- TEKS INFO HEATMAP -->
                            <div class="ms-3">
                                <p class="mb-1 d-flex align-items-center">
                                    <span
                                        style="display:inline-block; width:18px; height:18px; background-color:#A6D96A; border-radius:50%; margin-right:6px;"></span>
                                    L (Low)
                                </p>
                                <p class="mb-1 d-flex align-items-center">
                                    <span
                                        style="display:inline-block; width:18px; height:18px; background-color:#FCE08B; border-radius:50%; margin-right:6px;"></span>
                                    M (Medium)
                                </p>
                                <p class="mb-1 d-flex align-items-center">
                                    <span
                                        style="display:inline-block; width:18px; height:18px; background-color:#F46D43; border-radius:50%; margin-right:6px;"></span>
                                    H (High)
                                </p>
                                <p class="mb-3 d-flex align-items-center">
                                    <span
                                        style="display:inline-block; width:18px; height:18px; background-color:#D73026; border-radius:50%; margin-right:6px;"></span>
                                    E (Extreme)
                                </p>
                                <p class="d-flex align-items-center" style="color: red;">* Selera Risiko Polibatam = 13</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROBABILITAS -->
                <div class="col-md-6 mb-3">
                    <div class="card p-3 h-100" style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Status Probabilitas Risiko</h6>
                        </div>

                        <!-- BAR PROGRESS -->
                        @foreach (['Low', 'Medium', 'High', 'Extreme'] as $level)
                            <div class="bar-container mb-2">
                                <div class="bar-label">{{ $level }}</div>
                                <div class="bar {{ strtolower($level) }}"
                                    style="width: {{ $probabilitasData[strtolower($level)] }}%;">
                                    {{ $probabilitasData[strtolower($level)] }}%
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- KONTEN -->
        <div class="card p-4 mb-4" style="border:1px solid #E5E7EB; box-shadow:0 6px 14px rgba(0,0,0,0.10);">
            <div class="row">
                @forelse ($konten as $item)
                    <div class="col-md-6 mb-4">
                        <div class="card card-illustration p-3 h-100 d-flex flex-column align-items-center justify-content-center"
                            style="border:1px solid #E5E7EB; box-shadow:0 3px 8px rgba(0,0,0,0.08);">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" width="100">
                            @else
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/konten.svg') }}" width="80" alt="Ilustrasi">
                                </div>
                            @endif
                            @if ($item->file)
                                <a href="{{ asset($item->file) }}" target="_blank" class="mt-2 fw-semibold text-center">
                                    {{ $item->judul }}
                                </a>
                            @else
                                <p class="text-center mt-2 fw-semibold">{{ $item->judul }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted mt-3">
                        <p>Belum ada konten yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const colorMap = {
                "L": "#A6D96A",
                "M": "#FCE08B",
                "H": "#F46D43",
                "E": "#D73026"
            };
            const savedColors = @json($colors);
            if (!savedColors || !Array.isArray(savedColors)) return;
            savedColors.forEach(item => {
                const row = item.row;
                const col = item.col;
                const level = item.color_level;
                const cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
                if (cell) {
                    const hex = colorMap[level] ?? level;
                    cell.style.backgroundColor = hex;
                    cell.textContent = level;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.dropdown-toggle');
            toggles.forEach(toggle => {
                toggle.parentElement.addEventListener('hide.bs.dropdown', function (e) {
                    if (e.clickEvent && !toggle.contains(e.clickEvent.target)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection