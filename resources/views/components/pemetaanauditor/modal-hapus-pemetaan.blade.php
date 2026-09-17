<div class="modal fade" id="hapusMappingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content text-center border-0 shadow-sm rounded-4">

            <div class="modal-body py-4">

                <div class="mb-3">
                    <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
                </div>

                <h6 class="fw-semibold mb-3">
                    Apakah Anda yakin ingin menghapus seluruh pemetaan unit untuk auditor ini?
                </h6>

                <form id="deleteMappingForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger px-4">
                            Hapus
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const delButtons = document.querySelectorAll('.delete-button');
    const delForm = document.getElementById('deleteMappingForm');

    delButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            delForm.action = `/pemetaan_auditor/delete_all/${id}`;
        });
    });
});
</script>
