<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModalJenis" tabindex="-1" aria-labelledby="tambahDataLabelJenis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabelJenis">Tambah Jenis Risiko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jenis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="modal" value="tambahJenis">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Risiko</label>
                        <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis"
                            name="jenis" value="{{ old('jenis') }}" required>

                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any() && old('modal') === 'tambahJenis')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tambahModal = new bootstrap.Modal(document.getElementById('tambahDataModalJenis'));
            tambahModal.show();
        });
    </script>
@endif
