<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModalJenis" tabindex="-1" aria-labelledby="editDataLabelJenis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabelJenis">Edit Jenis Risiko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editJenisForm" method="POST"
                action="{{ old('edit_id') ? route('jenis.update', old('edit_id')) : '' }}">
                @csrf
                <input type="hidden" name="modal" value="editJenis">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-jenis" class="form-label">Jenis Risiko</label>
                        <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                            id="edit-jenis" name="jenis" value="{{ old('jenis') }}" required>

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

@if ($errors->any() && old('modal') === 'editJenis')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = new bootstrap.Modal(document.getElementById('editDataModalJenis'));
            editModal.show();
        });
    </script>
@endif

{{-- Script untuk Isi data modal edit --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-jenis-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                document.getElementById('edit-jenis').value = nama;
                document.getElementById('editJenisForm').action = `/jenis/update/${id}`;
            });
        });
    });
</script>
