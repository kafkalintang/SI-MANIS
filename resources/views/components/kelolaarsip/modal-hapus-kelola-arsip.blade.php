<!-- Modal Hapus Kelola Arsip -->
<div class="modal fade" id="hapusKelolaArsipModal" tabindex="-1" aria-labelledby="hapusKelolaArsipLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-sm rounded-4">
      <div class="modal-body py-4">
        <div class="mb-3">
          <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
        </div>
        <h6 class="fw-semibold mb-3">Apakah anda yakin ingin menghapus data ini?</h6>

        <form id="deleteKelolaArsipForm" method="POST">
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
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteKelolaArsipForm = document.getElementById('deleteKelolaArsipForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                deleteKelolaArsipForm.action = `/kelola_arsip/${id}`;
            });
        });
    });
</script>
