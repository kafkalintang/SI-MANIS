<!-- Modal Universal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahDataLabel">Judul Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="modalTambahDataForm" method="POST">
        @csrf
        <input type="hidden" name="modal" id="modalName">

        <div class="modal-body">

          <div class="mb-3">
            <label id="modalFieldLabel" class="form-label"></label>
            <input id="modalFieldInput" type="text" class="form-control" name="" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Simpan</button>

        </div>
      </form>

    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-modal-type]").forEach(button => {
        button.addEventListener("click", function () {
            
            // Ambil atribut
            const title = this.dataset.title;
            const route = this.dataset.route;
            const field = this.dataset.field;
            const label = this.dataset.label;
            const modalName = this.dataset.modal;

            // Set judul
            document.getElementById("modalTambahDataLabel").innerText = title;

            // Set route form
            document.getElementById("modalTambahDataForm").action = route;

            // Set hidden input
            document.getElementById("modalName").value = modalName;

            // Set label field
            document.getElementById("modalFieldLabel").innerText = label;

            // Set input name
            const input = document.getElementById("modalFieldInput");
            input.name = field;
            input.placeholder = label;
            input.value = "";
        });
    });
});
</script>
