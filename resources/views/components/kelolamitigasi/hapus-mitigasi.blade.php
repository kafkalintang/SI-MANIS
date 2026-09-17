<!-- Modal Hapus Data Mitigasi -->
<div class="modal fade" id="hapusMitigasiModal" tabindex="-1" aria-labelledby="hapusMitigasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center border-0 shadow-sm rounded-4">
        <div class="modal-body py-4">
          <div class="mb-3">
            <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
          </div>
          <h6 class="fw-semibold mb-3">Apakah anda yakin ingin menghapus data mitigasi ini?</h6>
  
          <form id="deleteMitigasiForm" method="POST">
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
  
  <!-- Script Modal Hapus Mitigasi -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const hapusModal = document.getElementById('hapusMitigasiModal');
    const deleteForm = document.getElementById('deleteMitigasiForm');
  
    // Saat tombol hapus diklik
    document.querySelectorAll('.delete-mitigasi-button').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.dataset.id;
  
        // Set action form sesuai ID mitigasi yang dipilih
        deleteForm.action = `{{ url('mitigasi') }}/${id}`;
  
        // Tampilkan modal (pastikan Bootstrap JS sudah dimuat)
        const modal = new bootstrap.Modal(hapusModal);
        modal.show();
      });
    });
  });
  </script>