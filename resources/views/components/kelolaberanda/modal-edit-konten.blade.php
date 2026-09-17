<!-- Modal Edit Konten -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabel">Edit Konten Beranda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>

                    <!-- File -->
                    <div class="mb-3">
                        <label class="form-label">File Lama</label>
                        <div id="preview_file" class="mb-2 text-primary fw-semibold"></div>

                        <label for="edit_file" class="form-label">Perbarui File</label>
                        <input type="file" class="form-control" id="edit_file" name="file">
                    </div>

                    <!-- Gambar -->
                    <div class="mb-4 d-none">
                        <label class="form-label d-block mb-1">Gambar Lama</label>

                        <!-- Preview Gambar -->
                        <img id="preview_gambar" src="" alt="Gambar Lama" class="rounded mb-2"
                            style="width: 120px; height: 90px; object-fit: cover; border: 1px solid #ddd;">

                        <!-- Label turun di bawah gambar -->
                        <label for="edit_gambar" class="form-label d-block mt-2">Perbarui Gambar</label>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar">
                    </div>


                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background-color:#007BFF;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btnEdit');
        const editForm = document.getElementById('editForm');
        const editJudul = document.getElementById('edit_judul');
        const previewGambar = document.getElementById('preview_gambar');
        const previewFile = document.getElementById('preview_file');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const judul = this.dataset.judul;
                const gambar = this.dataset.gambar;
                const file = this.dataset.file;
                const fileNama = this.dataset.fileNama;

                editForm.action = `/kelola-beranda/${id}`;
                editJudul.value = judul;

                // tampilkan gambar lama
                if (gambar) {
                    previewGambar.src = gambar;
                } else {
                    previewGambar.src = '';
                }

                // tampilkan file lama
                if (file) {
                    previewFile.innerHTML = `<a href="/storage/${file}" target="_blank">${fileNama}</a>`;
                } else {
                    previewFile.innerHTML = '<span class="text-muted">Tidak ada file</span>';
                }
            });
        });
    });
</script>