<!-- Modal Tambah Data -->
<style>
    .form-control,
    .form-select {
        border-radius: 8px;
        height: 42px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        position: absolute;
        right: 10px;
        top: 83%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .mb-3 {
        position: relative;
    }
</style>

<!-- MODAL TAMBAH MITIGASI -->
<div class="modal fade" id="tambahDataMitigasiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Mitigasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('mitigasi.store') }}" method="POST">
                @csrf

                <input type="hidden" name="registrasi_id" id="registrasi_id_tambah">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Isu/Risiko</label>
                        <select class="form-select" name="isurisiko" id="select_isurisiko" required>
                            <option value="">Memuat...</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rencana Aksi (Kebijakan, SOP, Training, dll)</label>
                        <input type="text" class="form-control" name="rencana_aksi" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pelaksanaan Rencana Aksi</label>
                        <input type="date" class="form-control" name="tanggal_pelaksanaan">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

