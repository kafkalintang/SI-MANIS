<!-- Modal Hapus Data IKU -->
<div class="modal fade" id="hapusPenilaianAuditorModal" tabindex="-1" aria-labelledby="hapusPenilaianAuditorLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-sm rounded-4">
      <div class="modal-body py-4">
        <div class="mb-3">
          <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
        </div>
        <h6 class="fw-semibold mb-3">Apakah anda yakin ingin menghapus data ini?</h6>
        <form id="form-hapus-penilaian" method="POST" action="">
          @csrf
          @method('DELETE')
          <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger px-4">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hapusModal = document.getElementById('hapusPenilaianAuditorModal');
    hapusModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('form-hapus-penilaian');
        form.action = `/penilaian/${id}`;
    });
});
</script>
