{{-- 1. UNIT KERJA --}}
<div>
    <button class="btn btn-secondary toggle-btn text-start" type="button" data-bs-toggle="collapse"
        data-bs-target="#unitKerja" aria-expanded="false">
        Unit Kerja +
    </button>
    <div class="collapse mt-2" id="unitKerja">
        <div class="card card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Unit Kerja</h6>
                <div class="d-flex ms-auto gap-2">
                    <button class="btn btn-success fw-bold btn-import" data-bs-toggle="modal"
                        data-bs-target="#importDataModal" data-template="{{ asset('template/unitkerja.xlsx') }}"
                        data-route="{{ route('formregis.import.unitkerja') }}">
                        <i class="fa-solid fa-upload"></i> Impor
                    </button>
                    <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahData"
                        data-modal-type data-title="Tambah Unit Kerja" data-route="{{ route('unitkerja.store') }}"
                        data-field="unitkerja" data-label="Unit Kerja" data-modal="tambahUnit">
                        <i class="fa-solid fa-plus me-1"></i>Tambah
                    </button>

                </div>
            </div>
            <form action="{{ route('kelola_regis') }}" method="GET" class="d-flex w-25 mb-3">
                <input type="text" name="search_unit" class="form-control" placeholder="Cari Unit Kerja..."
                    value="{{ request('search_unit') }}">
                <button type="submit" class="btn btn-primary btn-sm ms-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Unit Kerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitKerja as $index => $unit)
                            <tr>
                                <td class="text-center">
                                    {{-- Checkbox Per Baris --}}
                                    <input type="checkbox" class="form-check-input check-unit"
                                        value="{{ $unit->id }}">
                                    {{ $unitKerja->firstItem() + $index }}
                                </td>
                                <td>{{ $unit->nama_unit }}</td>
                                <td class="centered">
                                    <button class="btn btn-sm btn-primary btn-edit-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalEditUniversal" data-id="{{ $unit->id }}"
                                        data-nama="{{ $unit->nama_unit }}" data-route="/unitkerja/update"
                                        data-title="Edit Unit Kerja" data-field="Unit Kerja" data-fieldname="unitkerja">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete-universal" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusUniversal" data-id="{{ $unit->id }}"
                                        data-route="/unitkerja/delete" data-name="Unit Kerja">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                {{-- CHECKBOX PILIH SEMUA --}}
                <div class="d-flex align-items-center gap-2">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="select-all-unit">
                        <label class="form-check-label" for="select-all-unit">
                            Pilih Semua
                        </label>
                    </div>
                    {{-- Tombol Hapus Semua --}}
                    <button type="button" id="delete-selected-unit" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </div>
                {{-- NAVIGASI PAGINASI --}}
                @if ($unitKerja->hasPages())
                    <div class="d-flex align-items-center gap-1">
                        <a class="btn btn-sm btn-light {{ $unitKerja->onFirstPage() ? 'disabled' : '' }}"
                            href="{{ $unitKerja->previousPageUrl() }}">
                            &larr;
                        </a>
                        @foreach ($unitKerja->getUrlRange(1, $unitKerja->lastPage()) as $page => $url)
                            <a class="btn btn-sm {{ $page == $unitKerja->currentPage() ? 'btn-primary' : 'btn-light' }}"
                                href="{{ $url }}">
                                {{ $page }}
                            </a>
                        @endforeach
                        <a class="btn btn-sm btn-light {{ !$unitKerja->hasMorePages() ? 'disabled' : '' }}"
                            href="{{ $unitKerja->nextPageUrl() }}">
                            &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
