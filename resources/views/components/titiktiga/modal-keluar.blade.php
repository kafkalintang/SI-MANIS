<!-- Modal Keluar -->
<div class="modal fade" id="keluarModal" tabindex="-1" aria-labelledby="keluarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm rounded-4 text-center p-3">
      
      <!-- Ikon Peringatan -->
      <div class="mb-3 mt-2">
        <i class="fa-solid fa-circle-exclamation fa-3x text-secondary"></i>
      </div>

      <!-- Pesan Konfirmasi -->
      <h6 class="fw-semibold mb-4">Apakah anda yakin ingin keluar?</h6>

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-center gap-2">
        <button type="button" class="btn btn-light border fw-semibold px-4" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger fw-semibold px-4">Keluar</button>
        </form>
      </div>

    </div>
  </div>
</div>
