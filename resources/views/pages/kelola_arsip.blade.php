@extends('layouts.pengguna')

@section('title', 'Kelola Arsip')

@push('modals')
    @include('components.kelolaarsip.modal-hapus-kelola-arsip')
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('css/registrasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/arsip_risiko.css') }}">

    <h3 class="mt-3 mb-4">Kelola Arsip</h3>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <label class="me-3">Urutkan berdasarkan</label>

        <form action="{{ route('kelola_arsip') }}" method="GET" class="d-flex align-items-center gap-2">

            {{-- Dropdown Unit Kerja --}}
            <select name="unit_kerja_id" id="unitkerja" class="form-select w-auto dropdown-fixed">
                <option value="">Unit Kerja</option>
                @foreach($unitKerja as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>

            {{-- Dropdown Tahun --}}
            <select name="tahun" id="tahun" class="form-select w-auto dropdown-fixed">
                <option value="">Tahun</option>
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>

            {{-- Dropdown Status --}}
            <select name="status" id="status" class="form-select w-auto dropdown-fixed">
                <option value="">Status</option>
                <option value="opened-meningkat" {{ request('status') == 'opened-meningkat' ? 'selected' : '' }}>Open (Meningkat)</option>
                <option value="opened-menurun" {{ request('status') == 'opened-menurun' ? 'selected' : '' }}>Open (Menurun)</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            {{-- Dropdown Probabilitas --}}
            <select name="probabilitas" id="probabilitas" class="form-select w-auto dropdown-fixed">
                <option value="">Probabilitas</option>
                <option value="Low" {{ request('probabilitas') == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ request('probabilitas') == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ request('probabilitas') == 'High' ? 'selected' : '' }}>High</option>
                <option value="Extreme" {{ request('probabilitas') == 'Extreme' ? 'selected' : '' }}>Extreme</option>
            </select>

            <button type="submit" id="btnSearch" class="btn btn-primary btn-sm ms-2" style="height: 35px; padding: 0 15px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        <form action="{{ route('arsip_risiko.export') }}" method="GET">
            <input type="hidden" name="unit_kerja_id" value="{{ request('unit_kerja_id') }}">
            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="probabilitas" value="{{ request('probabilitas') }}">
            
            <button type="submit" class="btn btn-success btn-sm ms-2 fw-bold" style="height: 35px; padding: 0 12px;">
                <i class="fa-solid fa-file-excel"></i> Ekspor
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
                            <th>#</th>
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
                            @php
                                $evaluasiTerakhir = $item->mitigasis->flatMap->evaluasis->sortByDesc('tahun')->first();
                            @endphp
                            {{-- Baris utama (registrasi) --}}
                            <tr class="data-row"
                                data-status="{{ $evaluasiTerakhir->status_pelaksanaan ?? '' }}"
                                data-tahun="{{ $evaluasiTerakhir->tahun ?? '' }}">
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary toggle-collapse" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#mitigasi{{ $item->id_registrasi }}"
                                        aria-expanded="false" aria-controls="mitigasi{{ $item->id_registrasi }}">
                                        +
                                    </button>
                                </td>
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
                                <td>{{ $item->status_registrasi }}</td>
                                <td>{{ $item->komentar ?? '-' }}</td>
                                <td class="text-center">
                                    <button 
                                        class="btn btn-sm btn-danger delete-button"
                                        data-id="{{ $item->id_registrasi }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusKelolaArsipModal">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Collapse Mitigasi -->
                            <tr class="collapse bg-light" id="mitigasi{{ $item->id_registrasi }}">
                                <td colspan="18">
                                    <div class="p-3">
                                        <!-- Tabel mitigasi -->
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th rowspan="2">Isu/Risiko</th>
                                                    <th colspan="2">Tindak Lanjut</th>
                                                </tr>
                                                <tr>
                                                    <th>Rencana Aksi</th>
                                                    <th>Tanggal Pelaksanaan Rencana Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($item->mitigasis && $item->mitigasis->count())
                                                    @foreach($item->mitigasis as $m)
                                                        <tr>
                                                            <td>{{ $m->isurisiko }}</td>
                                                            <td>{{ $m->rencana_aksi }}</td>
                                                            <td>{{ $m->tanggal_pelaksanaan ? \Carbon\Carbon::parse($m->tanggal_pelaksanaan)->format('d M Y') : '-' }}</td>
                                                        </tr>

                                                        {{-- Tabel Evaluasi --}}
                                                        <tr>
                                                            <td colspan="17" class="bg-white">
                                                                <div class="ms-4 mt-3">
                                                                    <table class="table table-sm table-bordered mb-0">
                                                                        <thead class="table-secondary text-center">
                                                                            <tr>
                                                                                <th>Triwulan</th>
                                                                                <th>Hasil Tindak Lanjut</th>
                                                                                <th>Tanggal Evaluasi</th>
                                                                                <th>Status Pelaksanaan</th>
                                                                                <th>Hasil Penerapan</th>
                                                                                <th>Bukti Dokumen</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($m->evaluasis as $e)
                                                                                <tr>
                                                                                    <td class="centered">{{ $e->triwulan }}-{{ $e->tahun }}</td>
                                                                                    <td>{{ $e->hasil_tindak_lanjut }}</td>
                                                                                    <td class="centered">
                                                                                        {{ $e->tanggal_evaluasi ? \Carbon\Carbon::parse($e->tanggal_evaluasi)->format('d M Y') : '-' }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @php
                                                                                            $status = $e->status_pelaksanaan;

                                                                                            switch ($status) {
                                                                                                case 'opened-menurun':
                                                                                                    $tampilStatus = 'Opened (Menurun)';
                                                                                                    break;

                                                                                                case 'opened-meningkat':
                                                                                                    $tampilStatus = 'Opened (Meningkat)';
                                                                                                    break;

                                                                                                case 'closed':
                                                                                                    $tampilStatus = 'Closed';
                                                                                                    break;

                                                                                                default:
                                                                                                    $tampilStatus = ucfirst($status);
                                                                                            }
                                                                                        @endphp
                                                                                        {{ $tampilStatus }}
                                                                                    </td>
                                                                                    <td>{{ $e->hasil_penerapan }}</td>
                                                                                    <td class="text-center align-middle">
                                                                                        @if ($e->dokumen_pendukung)
                                                                                            <a href="{{ $e->dokumen_pendukung }}" target="_blank"
                                                                                                class="btn btn-sm btn-secondary">
                                                                                                <i class="fa-solid fa-eye"></i>
                                                                                            </a>
                                                                                        @else
                                                                                            <span>-</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            @if ($m->evaluasis->isEmpty())
                                                                                <tr>
                                                                                    <td colspan="7" class="text-center text-muted">Belum ada evaluasi</td>
                                                                                </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                    {{-- Tabel Review Auditor --}}
                                                                    @php
                                                                        $mitigasiTerakhir = $item->mitigasis->sortByDesc('id_mitigasi')->first();
                                                                    @endphp

                                                                    @if ($mitigasiTerakhir && $mitigasiTerakhir->evaluasis->count() > 0)
                                                                        <div class="mt-4">
                                                                            <table class="table table-sm table-bordered mb-0">
                                                                                <thead class="table-secondary text-center">
                                                                                    <tr>
                                                                                        <th>Triwulan</th>
                                                                                        <th>Catatan Hasil Review</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @php $adaPenilaian = false; @endphp

                                                                                    @foreach ($mitigasiTerakhir->evaluasis as $evaluasi)
                                                                                        @if ($evaluasi->penilaian && $evaluasi->penilaian->count() > 0)
                                                                                            @php $adaPenilaian = true; @endphp
                                                                                            @foreach ($evaluasi->penilaian as $p)
                                                                                                <tr>
                                                                                                    <td class="centered">{{ $evaluasi->triwulan }}-{{ $evaluasi->tahun ?? '-' }}</td>
                                                                                                    <td>{{ $p->uraian ?? '-' }}</td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @endforeach

                                                                                    @unless($adaPenilaian)
                                                                                        <tr>
                                                                                            <td colspan="2" class="text-center text-muted">Belum ada review auditor</td>
                                                                                        </tr>
                                                                                    @endunless
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center text-muted">Tidak ada registrasi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> 

    <script>
        // --- Bagian tombol + / − ---
        document.querySelectorAll('.toggle-collapse').forEach(button => {
            const targetSelector = button.getAttribute('data-bs-target');
            const target = document.querySelector(targetSelector);

            const collapseInstance = new bootstrap.Collapse(target, {
                toggle: false
            });

            target.addEventListener('shown.bs.collapse', () => {
                button.textContent = '−';
            });

            target.addEventListener('hidden.bs.collapse', () => {
                button.textContent = '+';
            });
        });
    </script>
@endsection
