<!-- Modal Edit Status -->
<style>
    .modal-dialog.modal-md-custom {
        max-width: 380px;
    }
</style>
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusLabel">Ubah Status Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editStatusForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-content-between mt-2 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="Belum Terverifikasi">
                            <label class="form-check-label" for="status1">Belum Terverifikasi</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="Terverifikasi" required>
                            <label class="form-check-label" for="status2">Terverifikasi</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Komentar Verifikasi</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3"
                            placeholder="Masukkan komentar"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".edit-status-button");
        const form = document.getElementById("editStatusForm");

        buttons.forEach(btn => {
            btn.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const status = this.getAttribute("data-status");
                const komentar = this.getAttribute("data-komentar");

                // set action form ke route update
                form.action = `/verifikasi-risiko/${id}`;

                // isi radio sesuai status saat ini
                document.getElementById("status1").checked = (status === "Belum Terverifikasi");
                document.getElementById("status2").checked = (status === "Terverifikasi");
                document.getElementById("komentar").value = komentar ?? '';
            });
        });
    });
</script>