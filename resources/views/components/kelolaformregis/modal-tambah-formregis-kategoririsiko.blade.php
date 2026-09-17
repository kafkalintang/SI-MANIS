<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModalKategori" tabindex="-1" aria-labelledby="tambahDataLabelKategori" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabelKategori">Tambah Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <input type="hidden" name="modal" value="tambahKategori">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Risiko</label>
                        <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                            id="kategori" name="kategori" value="{{ old('kategori') }}" required>

                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any() && old('modal') === 'tambahKategori')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tambahModal = new bootstrap.Modal(document.getElementById('tambahDataModalKategori'));
            tambahModal.show();
        });
    </script>
@endif
