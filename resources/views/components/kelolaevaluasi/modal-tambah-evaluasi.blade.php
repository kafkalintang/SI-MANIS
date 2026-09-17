<!-- MODAL TAMBAH EVALUASI -->
<div class="modal fade" id="tambahEvaluasiModal" tabindex="-1" aria-labelledby="tambahDataEvaluasiLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Evaluasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('evaluasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="mitigasi_id" id="evaluasi-mitigasi-id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Triwulan</label>
                        <select name="triwulan" class="form-select" required>
                            <option value="" selected disabled>Pilih Triwulan</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" class="form-control" name="tahun" placeholder="Masukan Tahun" required
                            pattern="\d{4}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            title="Masukkan tahun (4 digit)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hasil Tindak Lanjut</label>
                        <input type="text" class="form-control" name="hasil_tindak_lanjut"
                            placeholder="Masukan Hasil Tindak Lanjut">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Evaluasi</label>
                        <input type="date" class="form-control" name="tanggal_evaluasi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Pelaksanaan Rencana Aksi</label>
                        <select class="form-select" name="status_pelaksanaan" required>
                            <option value="" selected disabled>Status</option>
                            <option value="closed">Closed</option>
                            <option value="opened-menurun">Opened (Menurun)</option>
                            <option value="opened-meningkat">Opened (Meningkat)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hasil Penerapan Manajemen Risiko</label>
                        <input type="text" class="form-control" name="hasil_penerapan"
                            placeholder="Masukan Hasil Manajemen Risiko">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dokumen Pendukung</label>
                        <input type="url" class="form-control" name="dokumen_pendukung"
                            placeholder="Tambahkan Dokumen Pendukung">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        // Tombol Tambah Evaluasi
        document.querySelectorAll('.tambah-evaluasi-btn').forEach(btn => {
            btn.addEventListener('click', function () {

                let mitigasiId = this.getAttribute('data-mitigasi');

                // isi hidden input di modal
                document.getElementById('evaluasi-mitigasi-id').value = mitigasiId;

            });
        });

    });
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.tambah-evaluasi-btn').forEach(btn => {
            btn.addEventListener('click', function () {

                let mitigasiId = this.dataset.mitigasi;
                let existingTriwulan = (this.dataset.triwulan || "").split(",").map(t => t.trim());

                // isi hidden input
                document.getElementById('evaluasi-mitigasi-id').value = mitigasiId;

                // Ambil select triwulan
                let selectTriwulan = document.querySelector('#tambahEvaluasiModal select[name="triwulan"]');

                // Reset semua option (enable lagi)
                selectTriwulan.querySelectorAll("option").forEach(opt => {
                    opt.disabled = false;
                });

                // Disable option yang sudah ada
                existingTriwulan.forEach(t => {
                    let opt = selectTriwulan.querySelector(`option[value="${t}"]`);
                    if (opt) opt.disabled = true;
                });

                // Reset pilihan biar user pilih lagi
                selectTriwulan.value = "";
            });
        });
    });
</script>