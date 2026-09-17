<!-- Modal Edit Universal -->
<div class="modal fade" id="modalEditUniversal" tabindex="-1" aria-labelledby="modalEditUniversalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditUniversalLabel">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formEditUniversal" method="POST">
        @csrf
        <input type="hidden" name="modal" value="editUniversal">
        <input type="hidden" id="inputEditName" name=""> <!-- DINAMIS -->

        <div class="modal-body">
          <div class="mb-3">
            <label id="labelEditUniversal" class="form-label">Nama</label>
            <input type="text" class="form-control" id="inputEditUniversal" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.btn-edit-universal').forEach((btn) => {
    btn.addEventListener('click', function() {

      const id = this.dataset.id;
      const nama = this.dataset.nama;
      const route = this.dataset.route;
      const title = this.dataset.title;
      const field = this.dataset.field;
      const fieldName = this.dataset.fieldname; 

      // Set judul dan label
      document.getElementById('modalEditUniversalLabel').textContent = title;
      document.getElementById('labelEditUniversal').textContent = field;

      // Set nilai input
      document.getElementById('inputEditUniversal').value = nama;

      // Set action form
      document.getElementById('formEditUniversal').action = `${route}/${id}`;

      // Set name sesuai controller
      document.getElementById('inputEditName').name = fieldName;
      document.getElementById('inputEditName').value = nama;
    });
  });

  // sinkron input utama ke hidden input
  document.getElementById('inputEditUniversal').addEventListener('input', function() {
    document.getElementById('inputEditName').value = this.value;
  });

});
</script>
