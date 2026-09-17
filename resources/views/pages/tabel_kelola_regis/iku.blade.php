{{-- 5. IKU TERKAIT --}}
<div>
    <button class="btn btn-secondary toggle-btn text-start" type="button" data-bs-toggle="collapse"
        data-bs-target="#ikuTerkait" aria-expanded="false">
        IKU Terkait +
    </button>
    <div class="collapse mt-2" id="ikuTerkait">
        <div class="card card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">IKU Terkait</h6>
                <div class="d-flex ms-auto gap-2">
                    <button class="btn btn-success fw-bold btn-import" data-bs-toggle="modal"
                        data-bs-target="#importDataModal" data-template="{{ asset('template/iku.xlsx') }}"
                        data-route="{{ route('formregis.import.iku') }}">
                        <i class="fa-solid fa-upload"></i> Impor
                    </button>
                    <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahData"
                        data-modal-type data-title="Tambah IKU" data-route="{{ route('iku.store') }}" data-field="iku"
                        data-label="IKU" data-modal="tambahIku">
                        <i class="fa-solid fa-plus me-1"></i>Tambah
                    </button>

                </div>
            </div>
            <form action="{{ route('kelola_regis') }}" method="GET" class="d-flex w-25 mb-3">
                <input type="text" name="search_iku" class="form-control" placeholder="Cari IKU..."
                    value="{{ request('search_iku') }}">
                <button type="submit" class="btn btn-primary btn-sm ms-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>IKU Terkait</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ikuTerkait as $index => $iku)
                            <tr>
                                <td class="text-center">
                                    {{-- Checkbox Per baris --}}
                                    <input type="checkbox" class="form-check-input check-iku"
                                        value="{{ $iku->id }}">
                                    {{ $ikuTerkait->firstItem() + $index }}
                                </td>
                                <td>{{ $iku->nama_iku }}</td>
                                <td class="centered">
                                    <button class="btn btn-sm btn-primary btn-edit-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalEditUniversal" data-id="{{ $iku->id }}"
                                        data-nama="{{ $iku->nama_iku }}" data-route="/iku/update" data-title="Edit IKU"
                                        data-field="IKU" data-fieldname="iku">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-delete-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusUniversal" data-id="{{ $iku->id }}"
                                        data-route="/iku/delete" data-name="IKU">
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
                        <input class="form-check-input" type="checkbox" id="select-all-iku">
                        <label class="form-check-label" for="select-all-iku">Pilih Semua</label>
                    </div>
                    <button type="button" id="delete-selected-iku" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </div>
                @if ($ikuTerkait->hasPages())
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn btn-sm btn-light {{ $ikuTerkait->onFirstPage() ? 'disabled' : '' }}"
                            href="{{ $ikuTerkait->previousPageUrl() }}">&larr;</a>
                        @foreach ($ikuTerkait->getUrlRange(1, $ikuTerkait->lastPage()) as $page => $url)
                            <a class="btn btn-sm {{ $page == $ikuTerkait->currentPage() ? 'btn-primary' : 'btn-light' }}"
                                href="{{ $url }}">{{ $page }}</a>
                        @endforeach
                        <a class="btn btn-sm btn-light {{ !$ikuTerkait->hasMorePages() ? 'disabled' : '' }}"
                            href="{{ $ikuTerkait->nextPageUrl() }}">&rarr;</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
