<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModalKategori" tabindex="-1" aria-labelledby="editDataLabelKategori" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabelKategori">Edit Kategori Risiko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editKategoriForm" method="POST"
                action="{{ old('edit_id') ? route('kategori.update', old('edit_id')) : '' }}">
                @csrf
                <input type="hidden" name="modal" value="editKategori">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-kategori" class="form-label">Unit Kerja</label>
                        <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                            id="edit-kategori" name="kategori" value="{{ old('kategori') }}" required>

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

@if ($errors->any() && old('modal') === 'editKategori')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = new bootstrap.Modal(document.getElementById('editDataModalKategori'));
            editModal.show();
        });
    </script>
@endif

{{-- Script untuk Isi data modal edit --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-kategori-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                document.getElementById('edit-kategori').value = nama;
                document.getElementById('editKategoriForm').action = `/kategori/update/${id}`;
            });
        });
    });
</script>
