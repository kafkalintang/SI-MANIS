<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModalProsesAktivitas" tabindex="-1" aria-labelledby="editDataLabelProsesAktivitas"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabelProsesAktivitas">Edit Proses/Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editProsesForm" method="POST"
                action="{{ old('edit_id') ? route('proses.update', old('edit_id')) : '' }}">
                @csrf
                <input type="hidden" name="modal" value="editProses">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-proses" class="form-label">Proses/Aktivitas</label>
                        <input type="text" class="form-control @error('proses') is-invalid @enderror"
                            id="edit-proses" name="proses" value="{{ old('proses') }}" required>

                        @error('proses')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit-unit-kerja" class="form-label">Unit Kerja</label>
                        <select id="edit-unit-kerja" name="unit_kerja_id" class="form-control" required>
                            @foreach ($allUnitKerja as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    
                        @error('unit_kerja_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@if ($errors->any() && old('modal') === 'editProses')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = new bootstrap.Modal(document.getElementById('editDataModalProsesAktivitas'));
            editModal.show();
        });
    </script>
@endif

{{-- Script untuk isi data modal edit --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-proses-button').forEach(button => {
            button.addEventListener('click', function () {
    
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const unit = this.dataset.unit; // <── ambil unit_kerja_id
    
                document.getElementById('edit-proses').value = nama;
                document.getElementById('edit-unit-kerja').value = unit;
    
                document.getElementById('editProsesForm').action = `/proses/update/${id}`;
            });
        });
    });
    </script>
