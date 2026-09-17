@extends('layouts.pengguna')

@section('title', 'Verifikasi Risiko')

@push('modals')
    @include('components.verifikasirisiko.modal-edit-status')
@endpush

@section('content')
    <!-- Konten -->
    <link rel="stylesheet" href="{{ asset('css/registrasi.css') }}">
    <h3 class="mt-3 mb-4">Verifikasi Risiko</h3>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <label class="me-3">Urutkan berdasarkan</label>

        <!-- Dropdown Unit Kerja dan Tahun -->
        <form action="{{ route('verifikasi_risiko') }}" method="GET" class="d-flex align-items-center gap-2">
            <select name="unit_kerja_id" id="unitkerja" class="form-select w-auto dropdown-fixed">
                <option value="">Pilih Unit Kerja</option>
                @foreach ($unitKerja as $uk)
                    <option value="{{ $uk->id }}" {{ request('unit_kerja_id') == $uk->id ? 'selected' : '' }}>
                        {{ $uk->nama_unit }}
                    </option>
                @endforeach
            </select>

            <button id="btnSearch" class="btn btn-primary btn-sm btn-search ms-2" style="height: 35px; padding: 0 15px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
    <p class="mt-4" style="color: red;">* Untuk melihat data sampai selesai, silakan geser tabel ke kanan.</p>
    <div id="hasilFilter" class="mt-2"></div>

    <!-- Card Wrapper -->
    <div class="card shadow-sm border-1">
        <div class="card-body">
            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>Unit Kerja</th>
                            <th>Proses/Aktifitas</th>
                            <th>Kategori Risiko</th>
                            <th>Jenis Risiko</th>
                            <th>Isu/Risiko</th>
                            <th>Jenis Isu</th>
                            <th>Akar Permasalahan</th>
                            <th>Dampak</th>
                            <th>IKU Terkait</th>
                            <th>Pihak Terkait</th>
                            <th>Kontrol/Pencegahan</th>
                            <th>Keparahan</th>
                            <th>Frekuensi</th>
                            <th>Probabilitas</th>
                            <th>Status Registrasi</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrasi as $item)
                        <tr>
                            <td>{{ $item->unitKerja->nama_unit ?? '-' }}</td>
                            <td>{{ $item->prosesAktivitas->nama_proses ?? '-' }}</td>
                            <td>{{ $item->kategoriRisiko->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->jenisRisiko->nama_jenis ?? '-' }}</td>
                            <td>{{ $item->isu_resiko }}</td>
                            <td>{{ $item->jenis_isu }}</td>
                            <td>{{ $item->akar_permasalahan }}</td>
                            <td>{{ $item->dampak }}</td>
                            <td>{{ $item->ikuTerkait->nama_iku ?? '-' }}</td>
                            <td>{{ $item->pihak_terkait }}</td>
                            <td>{{ $item->kontrol_pencegahan }}</td>
                            <td>{{ $item->keparahan_detail }}</td>
                            <td>{{ $item->frekuensi_detail }}</td>
                            <td>{{ $item->probabilitas }}</td>
                            <td class="centered">{{ $item->status_registrasi }}</td>
                            <td>{{ $item->komentar ?? '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm edit-status-button" data-bs-toggle="modal"
                                    data-bs-target="#editStatusModal" data-id="{{ $item->id_registrasi }}"
                                    data-status="{{ $item->status_registrasi }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center text-muted">Tidak ada risiko yang perlu diverifikasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> <!-- /card-body -->
    </div> <!-- /card -->

    {{-- Script untuk alert CRUD --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @php
                $success = session()->pull('success');
                $error = session()->pull('error');
            @endphp

            @if ($success)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ $success }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            @endif

            @if ($error)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ $error }}',
                    showConfirmButton: true,
                });
            @endif
        });
    </script>
@endsection
