<!-- Modal Edit Data IKU -->
<div class="modal fade" id="editDataModalIku" tabindex="-1" aria-labelledby="editDataLabelIku" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabelIku">Edit IKU Terkait</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editIkuForm" method="POST"
                action="{{ old('edit_id') ? route('iku.update', old('edit_id')) : '' }}">
                @csrf
                <input type="hidden" name="modal" value="editIku">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-iku" class="form-label">IKU Terkait</label>
                        <input type="text" class="form-control @error('iku') is-invalid @enderror"
                            id="edit-iku" name="iku" value="{{ old('iku') }}" required>

                        @error('iku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any() && old('modal') === 'editIku')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = new bootstrap.Modal(document.getElementById('editDataModalIku'));
            editModal.show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-iku-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                document.getElementById('edit-iku').value = nama;
                document.getElementById('editIkuForm').action = `/iku/update/${id}`;
            });
        });
    });
</script>
