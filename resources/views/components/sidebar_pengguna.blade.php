{{-- Sidebar App CSS --}}
<link rel="stylesheet" href="{{ asset('css/sidebar_pengguna.css') }}">

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();
    $roleString = $user->role ?? '';
    $userRoles = array_map('trim', explode(',', $roleString));
    $unit = strtolower($user->unitKerja->nama_unit ?? '');

    $isP4M = str_contains($unit, 'p4m');
    $isManajemen = str_contains($unit, 'manajemen');
    $isUnitNormal = $unit && !$isP4M && !$isManajemen;

    $isKepalaUnit = in_array('kepala_unit', $userRoles);
    $isAuditor = in_array('auditor', $userRoles);
    $isP4mRole = in_array('p4m', $userRoles);
@endphp

<div class="sidebar" id="sidebar">
    {{-- MENU UTAMA --}}
    <p class="px-3 text-uppercase small mb-2">Menu Utama</p>

    <a href="{{ route('beranda') }}" class="{{ Route::is('beranda') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('arsip_risiko') }}" class="{{ Route::is('arsip_risiko*') ? 'active' : '' }}">
        <i class="fa-solid fa-box-archive"></i> Arsip Risiko
    </a>

    {{-- MENU KEPALA UNIT --}}
    @if ($isKepalaUnit || ($isAuditor && $isUnitNormal) || $isP4mRole)
        <p class="px-3 text-uppercase small mt-3 mb-2">Menu Kepala Unit</p>
        {{-- Menggunakan registrasi.* agar aktif saat di halaman index, create, atau edit --}}
        <a href="{{ route('registrasi.index') }}" class="{{ Route::is('registrasi*') ? 'active' : '' }}">
            <i class="fa-solid fa-pen-to-square"></i> Registrasi dan Mitigasi Risiko
        </a>
    @endif

    {{-- MENU P4M --}}
    @if ($isP4mRole || $isAuditor)
        <p class="px-3 text-uppercase small mt-3 mb-2">Menu P4M</p>

        {{-- VERIFIKASI RISIKO P4M & AUDITOR --}}
        @if ($isP4mRole || $isAuditor)
            <a href="{{ route('verifikasi_risiko') }}" class="{{ Route::is('verifikasi_risiko*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-check"></i> Verifikasi Risiko
            </a>
        @endif

        @if ($isP4mRole)
            <a href="{{ route('kelola_beranda') }}" class="{{ Route::is('kelola_beranda*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Kelola Beranda
            </a>

            <a href="{{ route('kelola_regis') }}" class="{{ Route::is('kelola_regis*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder"></i> Kelola Form Regis
            </a>

            <a href="{{ route('kelola_pengguna') }}" class="{{ Route::is('kelola_pengguna*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Kelola Pengguna
            </a>

            <a href="{{ route('pemetaan_auditor') }}" class="{{ Route::is('pemetaan_auditor*') ? 'active' : '' }}">
                <i class="fa-solid fa-sitemap"></i> Pemetaan Auditor
            </a>

            <a href="{{ route('kelola_arsip') }}" class="{{ Route::is('kelola_arsip*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i> Kelola Arsip
            </a>
        @endif
    @endif

    {{-- MENU AUDITOR --}}
    @if ($isAuditor || $isP4mRole || ($isKepalaUnit && $isUnitNormal && str_contains($unit, 'auditor')))
        <p class="px-3 text-uppercase small mt-3 mb-2">Menu Auditor</p>
        <a href="{{ route('penilaian') }}"><i class="fa-solid fa-list-check"></i> Review Auditor</a>
    @endif
</div>