<!-- Modal Edit Evaluasi -->
<div class="modal fade" id="editDataEvaluasiModal" tabindex="-1" aria-labelledby="editDataEvaluasiLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataEvaluasiLabel">Edit Evaluasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEvaluasiForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">
                    <input type="hidden" id="edit_mitigasi_id" name="mitigasi_id">

                    <div class="mb-3">
                        <label for="edit_triwulan" class="form-label">Triwulan</label>
                        <select class="form-select" id="edit_triwulan" name="triwulan" required>
                            <option value="" disabled>Pilih Triwulan</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_tahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="edit_tahun" name="tahun" placeholder="Masukan Tahun"
                            required pattern="\d{4}" maxlength="4"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" title="Masukkan tahun (4 digit)">
                    </div>

                    <div class="mb-3">
                        <label for="edit_hasiltindaklanjut" class="form-label">Hasil Tindak Lanjut</label>
                        <input type="text" class="form-control" id="edit_hasiltindaklanjut" name="hasil_tindak_lanjut">
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggalevaluasi" class="form-label">Tanggal Evaluasi</label>
                        <input type="date" class="form-control" id="edit_tanggalevaluasi" name="tanggal_evaluasi">
                    </div>

                    <div class="mb-3">
                        <label for="edit_statuspelaksanaan" class="form-label">Status Pelaksanaan Rencana Aksi</label>
                        <select class="form-select" id="edit_statuspelaksanaan" name="status_pelaksanaan" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="closed">Closed</option>
                            <option value="opened-menurun">Opened (Menurun)</option>
                            <option value="opened-meningkat">Opened (Meningkat)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_hasilpenerapan" class="form-label">Hasil Penerapan Manajemen Risiko</label>
                        <input type="text" class="form-control" id="edit_hasilpenerapan" name="hasil_penerapan">
                    </div>

                    <div class="mb-3">
                        <label for="edit_dokumenpendukung" class="form-label">Dokumen Pendukung</label>
                        <input type="url" class="form-control" id="edit_dokumenpendukung" name="dokumen_pendukung">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.edit-evaluasi-btn').forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;

            document.getElementById('editEvaluasiForm').action = `/evaluasi/${id}`;
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_mitigasi_id').value = this.dataset.mitigasiId;

            document.getElementById('edit_triwulan').value = this.dataset.triwulan;
            document.getElementById('edit_tahun').value = this.dataset.tahun;
            document.getElementById('edit_hasiltindaklanjut').value = this.dataset.hasil;
            document.getElementById('edit_tanggalevaluasi').value = this.dataset.tanggal;
            document.getElementById('edit_statuspelaksanaan').value = this.dataset.status;
            document.getElementById('edit_hasilpenerapan').value = this.dataset.penerapan;
            document.getElementById('edit_dokumenpendukung').value = this.dataset.dokumen;
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.edit-evaluasi-btn').forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;
            const mitigasiId = this.dataset.mitigasiId;
            const currentTriwulan = parseInt(this.dataset.triwulan);
            const used = (this.dataset.used || '').split(',').map(Number);

            document.getElementById('editEvaluasiForm').action = `/evaluasi/${id}`;
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_mitigasi_id').value = mitigasiId;

            document.getElementById('edit_triwulan').value = currentTriwulan;
            document.getElementById('edit_tahun').value = this.dataset.tahun;
            document.getElementById('edit_hasiltindaklanjut').value = this.dataset.hasil;
            document.getElementById('edit_tanggalevaluasi').value = this.dataset.tanggal;
            document.getElementById('edit_statuspelaksanaan').value = this.dataset.status;
            document.getElementById('edit_hasilpenerapan').value = this.dataset.penerapan;
            document.getElementById('edit_dokumenpendukung').value = this.dataset.dokumen;

            document.querySelectorAll('#edit_triwulan option').forEach(opt => opt.disabled = false);

            used.forEach(tw => {
                if (tw !== currentTriwulan) {
                    let opt = document.querySelector(`#edit_triwulan option[value="${tw}"]`);
                    if (opt) opt.disabled = true;
                }
            });
        });
    });

});
</script>
