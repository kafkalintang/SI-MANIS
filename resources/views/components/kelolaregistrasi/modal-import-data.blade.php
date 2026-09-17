<!-- Modal Import Data -->
<div class="modal fade" id="importRegistrasiModal" tabindex="-1" aria-labelledby="importRegistrasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg border-0">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-bold" id="importRegistrasiModalLabel">Import Data Form Regis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="importForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Pastikan file Excel Anda sesuai dengan format yang disediakan.
                        <br>
                        <a id="templateLink" href="#" download class="text-decoration-none">
                            <i class="fa-solid fa-file-excel me-1 text-success"></i>
                            Unduh Template Excel
                        </a>
                    </p>
                
                    <div class="mb-3">
                        <label for="file_import" class="form-label fw-semibold">Pilih File Excel</label>
                        <input type="file" name="file" id="file_import" class="form-control" accept=".xls,.xlsx"
                            required>
                        <small class="text-muted d-block mt-1">
                            Format yang diterima: .xls atau .xlsx
                        </small>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-upload me-1"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-import').forEach(btn => {
        btn.addEventListener('click', function () {
            const route = this.getAttribute('data-route');
            const template = this.getAttribute('data-template');
    
            // set action form
            document.querySelector('#importRegistrasiModal form')
                .setAttribute('action', route);
    
            // set link download template
            const link = document.querySelector('#templateLink');
            link.setAttribute('href', template);
    
            // set nama file saat download
            link.setAttribute('download', 'template_registrasi.xlsx');
        });
    });
    </script>
    
