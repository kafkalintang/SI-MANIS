<!-- Modal Hapus Data Evaluasi -->
<div class="modal fade" id="hapusEvaluasiModal" tabindex="-1" aria-labelledby="hapusEvaluasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-sm rounded-4">
      <div class="modal-body py-4">
        <div class="mb-3">
          <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
        </div>
        <h6 class="fw-semibold mb-3">Apakah anda yakin ingin menghapus data evaluasi ini?</h6>

        <form id="deleteEvaluasiForm" method="POST">
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
  document.addEventListener('DOMContentLoaded', () => {
    const hapusModal = document.getElementById('hapusEvaluasiModal');
    const deleteForm = document.getElementById('deleteEvaluasiForm');

    // Saat tombol hapus diklik
    document.querySelectorAll('.delete-evaluasi-btn').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.dataset.id;

        // Set action form sesuai ID evaluasi yang dipilih
        deleteForm.action = `{{ url('evaluasi') }}/${id}`;

        // Tampilkan modal (pastikan Bootstrap JS sudah dimuat)
        const modal = new bootstrap.Modal(hapusModal);
        modal.show();
      });
    });
  });
</script>