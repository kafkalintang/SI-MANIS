 {{-- 3. KATEGORI RISIKO --}}
 <div>
     <button class="btn btn-secondary toggle-btn text-start" type="button" data-bs-toggle="collapse"
         data-bs-target="#kategoriRisiko" aria-expanded="false">
         Kategori Risiko +
     </button>
     <div class="collapse mt-2" id="kategoriRisiko">
         <div class="card card-body">
             <div class="d-flex justify-content-between align-items-center mb-2">
                 <h6 class="fw-bold mb-0">Kategori Risiko</h6>
                 <div class="d-flex ms-auto gap-2">
                     <button class="btn btn-success fw-bold btn-import" data-bs-toggle="modal"
                         data-bs-target="#importDataModal" data-template="{{ asset('template/kategori_risiko.xlsx') }}"
                         data-route="{{ route('formregis.import.kategori') }}">
                         <i class="fa-solid fa-upload"></i> Impor
                     </button>
                     <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahData"
                         data-modal-type data-title="Tambah Kategori Risiko" data-route="{{ route('kategori.store') }}"
                         data-field="kategori" data-label="Kategori Risiko" data-modal="tambahKategori">
                         <i class="fa-solid fa-plus me-1"></i>Tambah
                     </button>

                 </div>
             </div>
             <form action="{{ route('kelola_regis') }}" method="GET" class="d-flex w-25 mb-3">
                 <input type="text" name="search_kategori" class="form-control" placeholder="Cari Kategori Risiko..."
                     value="{{ request('search_kategori') }}">
                 <button type="submit" class="btn btn-primary btn-sm ms-2">
                     <i class="fa-solid fa-magnifying-glass"></i>
                 </button>
             </form>
             <div class="table-responsive">
                 <table class="table table-bordered w-100">
                     <thead class="table-secondary text-center">
                         <tr>
                             <th class="text-center">No</th>
                             <th>Kategori Risiko</th>
                             <th>Aksi</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($kategoriRisiko as $index => $kategori)
                             <tr>
                                 <td class="text-center">
                                     {{-- Checkbox Per Baris --}}
                                     <input type="checkbox" class="form-check-input check-kategori"
                                         value="{{ $kategori->id }}">
                                     {{ $kategoriRisiko->firstItem() + $index }}
                                 </td>
                                 <td>{{ $kategori->nama_kategori }}</td>
                                 <td class="centered">
                                     <button class="btn btn-sm btn-primary btn-edit-universal" data-bs-toggle="modal"
                                         data-bs-target="#modalEditUniversal" data-id="{{ $kategori->id }}"
                                         data-nama="{{ $kategori->nama_kategori }}" data-route="/kategori/update"
                                         data-title="Edit Kategori Risiko" data-field="Kategori Risiko"
                                         data-fieldname="kategori">
                                         <i class="fa-solid fa-pen-to-square"></i>
                                     </button>
                                     <button class="btn btn-danger btn-sm btn-delete-universal" data-bs-toggle="modal"
                                         data-bs-target="#modalHapusUniversal" data-id="{{ $kategori->id }}"
                                         data-route="/kategori/delete" data-name="Kategori Risiko">
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
                         <input class="form-check-input" type="checkbox" id="select-all-kategori">
                         <label class="form-check-label" for="select-all-kategori">Pilih Semua</label>
                     </div>
                     <button type="button" id="delete-selected-kategori" class="btn btn-sm btn-danger">
                         Hapus
                     </button>
                 </div>
                 @if ($kategoriRisiko->hasPages())
                     <div class="d-flex align-items-center gap-1">
                         <a class="btn btn-sm btn-light {{ $kategoriRisiko->onFirstPage() ? 'disabled' : '' }}"
                             href="{{ $kategoriRisiko->previousPageUrl() }}">&larr;</a>
                         @foreach ($kategoriRisiko->getUrlRange(1, $kategoriRisiko->lastPage()) as $page => $url)
                             <a class="btn btn-sm {{ $page == $kategoriRisiko->currentPage() ? 'btn-primary' : 'btn-light' }}"
                                 href="{{ $url }}">{{ $page }}</a>
                         @endforeach
                         <a class="btn btn-sm btn-light {{ !$kategoriRisiko->hasMorePages() ? 'disabled' : '' }}"
                             href="{{ $kategoriRisiko->nextPageUrl() }}">&rarr;</a>
                     </div>
                 @endif
             </div>
         </div>
     </div>
 </div>
