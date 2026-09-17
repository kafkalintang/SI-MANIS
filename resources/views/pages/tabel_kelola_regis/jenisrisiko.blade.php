{{-- 4. JENIS RISIKO --}}
<div>
    <button class="btn btn-secondary toggle-btn text-start" type="button" data-bs-toggle="collapse"
        data-bs-target="#jenisRisiko" aria-expanded="false">
        Jenis Risiko +
    </button>
    <div class="collapse mt-2" id="jenisRisiko">
        <div class="card card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Jenis Risiko</h6>
                <div class="d-flex ms-auto gap-2">
                    <button class="btn btn-success fw-bold btn-import" data-bs-toggle="modal"
                        data-bs-target="#importDataModal" data-template="{{ asset('template/jenis_risiko.xlsx') }}"
                        data-route="{{ route('formregis.import.jenis') }}">
                        <i class="fa-solid fa-upload"></i> Impor
                    </button>
                    <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahData"
                        data-modal-type data-title="Tambah Jenis Risiko" data-route="{{ route('jenis.store') }}"
                        data-field="jenis" data-label="Jenis Risiko" data-modal="tambahJenis">
                        <i class="fa-solid fa-plus me-1"></i>Tambah
                    </button>

                </div>
            </div>
            <form action="{{ route('kelola_regis') }}" method="GET" class="d-flex w-25 mb-3">
                <input type="text" name="search_jenis" class="form-control" placeholder="Cari Jenis Risiko..."
                    value="{{ request('search_jenis') }}">
                <button type="submit" class="btn btn-primary btn-sm ms-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Jenis Risiko</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenisRisiko as $index => $jenis)
                            <tr>
                                <td class="text-center">
                                    {{-- Checkbox Per Baris --}}
                                    <input type="checkbox" class="form-check-input check-jenis"
                                        value="{{ $jenis->id }}">
                                    {{ $jenisRisiko->firstItem() + $index }}
                                </td>
                                <td>{{ $jenis->nama_jenis }}</td>
                                <td class="centered">
                                    <button class="btn btn-sm btn-primary btn-edit-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalEditUniversal" data-id="{{ $jenis->id }}"
                                        data-nama="{{ $jenis->nama_jenis }}" data-route="/jenis/update"
                                        data-title="Edit Jenis Risiko" data-field="Jenis Risiko" data-fieldname="jenis">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-delete-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusUniversal" data-id="{{ $jenis->id }}"
                                        data-route="/jenis/delete" data-name="Jenis Risiko">
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
                        <input class="form-check-input" type="checkbox" id="select-all-jenis">
                        <label class="form-check-label" for="select-all-jenis">Pilih Semua</label>
                    </div>
                    <button type="button" id="delete-selected-jenis" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </div>
                @if ($jenisRisiko->hasPages())
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn btn-sm btn-light {{ $jenisRisiko->onFirstPage() ? 'disabled' : '' }}"
                            href="{{ $jenisRisiko->previousPageUrl() }}">&larr;</a>
                        @foreach ($jenisRisiko->getUrlRange(1, $jenisRisiko->lastPage()) as $page => $url)
                            <a class="btn btn-sm {{ $page == $jenisRisiko->currentPage() ? 'btn-primary' : 'btn-light' }}"
                                href="{{ $url }}">{{ $page }}</a>
                        @endforeach
                        <a class="btn btn-sm btn-light {{ !$jenisRisiko->hasMorePages() ? 'disabled' : '' }}"
                            href="{{ $jenisRisiko->nextPageUrl() }}">&rarr;</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
