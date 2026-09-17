{{-- 2. PROSES/AKTIVITAS --}}
<div>
    <button class="btn btn-secondary toggle-btn text-start" type="button" data-bs-toggle="collapse"
        data-bs-target="#prosesAktivitas" aria-expanded="false">
        Proses/Aktivitas +
    </button>
    <div class="collapse mt-2" id="prosesAktivitas">
        <div class="card card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Proses/Aktivitas</h6>
                <div class="d-flex ms-auto gap-2">
                    <button class="btn btn-success fw-bold btn-import" 
                        data-bs-toggle="modal"
                        data-bs-target="#importDataModal" 
                        data-template="{{ route('proses.export') }}"
                        data-route="{{ route('formregis.import.proses') }}">
                        <i class="fa-solid fa-upload"></i> Impor
                    </button>
                    <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#tambahDataModalProsesAktivitas"
                        data-modal-type data-title="Tambah Proses / Aktivitas" data-route="{{ route('proses.store') }}"
                        data-field="proses" data-label="Proses / Aktivitas" data-modal="tambahProses">
                        <i class="fa-solid fa-plus me-1"></i>Tambah
                    </button>

                </div>
            </div>
            <form action="{{ route('kelola_regis') }}" method="GET" class="d-flex w-25 mb-3">
                <input type="text" name="search_proses" class="form-control" placeholder="Cari Proses/Aktivitas..."
                    value="{{ request('search_proses') }}">
                <button type="submit" class="btn btn-primary btn-sm ms-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Proses/Aktivitas</th>
                            <th>Unit Kerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prosesAktivitas as $index => $proses)
                            <tr>
                                <td class="text-center">
                                    {{-- Checkbox per baris --}}
                                    <input type="checkbox" class="form-check-input check-proses"
                                        value="{{ $proses->id }}">
                                    {{ $prosesAktivitas->firstItem() + $index }}
                                </td>
                                <td>{{ $proses->nama_proses }}</td>
                                <td>{{ $proses->unitKerja->nama_unit ?? '-' }}</td>

                                <td class="centered">
                                    <button class="btn btn-sm btn-primary edit-proses-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editDataModalProsesAktivitas"
                                        data-id="{{ $proses->id }}"
                                        data-nama="{{ $proses->nama_proses }}"
                                        data-unit="{{ $proses->unit_kerja_id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-delete-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusUniversal" data-id="{{ $proses->id }}"
                                        data-route="/proses/delete" data-name="Proses / Aktivitas">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="select-all-proses">
                        <label class="form-check-label" for="select-all-proses">Pilih Semua</label>
                    </div>
                    <button type="button" id="delete-selected-proses" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </div>
                @if ($prosesAktivitas->hasPages())
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn btn-sm btn-light {{ $prosesAktivitas->onFirstPage() ? 'disabled' : '' }}"
                            href="{{ $prosesAktivitas->previousPageUrl() }}">&larr;</a>
                        @foreach ($prosesAktivitas->getUrlRange(1, $prosesAktivitas->lastPage()) as $page => $url)
                            <a class="btn btn-sm {{ $page == $prosesAktivitas->currentPage() ? 'btn-primary' : 'btn-light' }}"
                                href="{{ $url }}">{{ $page }}</a>
                        @endforeach
                        <a class="btn btn-sm btn-light {{ !$prosesAktivitas->hasMorePages() ? 'disabled' : '' }}"
                            href="{{ $prosesAktivitas->nextPageUrl() }}">&rarr;</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-import').forEach(btn => {
        btn.addEventListener('click', function () {
            const route = this.getAttribute('data-route');
            const template = this.getAttribute('data-template');
    
            const form = document.querySelector('#importDataModal form');
            const templateLink = document.querySelector('#templateLink');
    
            form.setAttribute('action', route);
            templateLink.style.display = 'inline-block';
            templateLink.setAttribute('href', template);
        });
    });
    </script>
    
    
