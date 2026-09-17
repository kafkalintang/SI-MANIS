<!-- Modal Edit Mitigasi -->
<div class="modal fade" id="editDataMitigasiModal" tabindex="-1" aria-labelledby="editDataMitigasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataMitigasiLabel">Edit Mitigasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMitigasiForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_isurisiko" class="form-label">Isu/Risiko</label>
                        <input type="text" class="form-control" id="edit_isurisiko" name="isurisiko">
                    </div>

                    <div class="mb-3">
                        <label for="edit_rencanaaksi" class="form-label">Rencana Aksi (Kebijakan, Panduan, SOP, alat,
                            Training, dll)</label>
                        <input type="text" class="form-control" id="edit_rencanaaksi" name="rencana_aksi" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggalpelaksanaan" class="form-label">Tanggal Pelakasanaan Rencana
                            Aksi</label>
                        <input type="date" class="form-control" id="edit_tanggalpelaksanaan" name="tanggal_pelaksanaan">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.edit-mitigasi').forEach(button => {
        button.addEventListener('click', function () {
            if (this.classList.contains('disabled')) {
                return;
            }

            const id = this.getAttribute('data-id');
            const form = document.getElementById('editMitigasiForm');
            form.action = '/mitigasi/' + id;

            // Isi form dengan data dari tombol
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_isurisiko').value = this.getAttribute('data-isurisiko');
            document.getElementById('edit_rencanaaksi').value = this.getAttribute('data-rencana');
            document.getElementById('edit_tanggalpelaksanaan').value = this.getAttribute('data-tanggal');
        });
    });
</script>