<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModalIku" tabindex="-1" aria-labelledby="tambahDataLabelIku" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahDataLabelIku">Tambah IKU Terkait</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('iku.store') }}" method="POST">
        @csrf
        <input type="hidden" name="modal" value="tambahIku">
        <div class="modal-body">
          <div class="mb-3">
            <label for="iku" class="form-label">IKU Terkait</label>
            <input type="text"
                   class="form-control @error('iku') is-invalid @enderror"
                   id="iku"
                   name="iku"
                   value="{{ old('iku') }}"
                   required>

            @error('iku')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->any() && old('modal') === 'tambahIku')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tambahModal = new bootstrap.Modal(document.getElementById('tambahDataModalIku'));
      tambahModal.show();
    });
  </script>
@endif
