<div class="modal fade" id="editMappingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pemetaan Auditor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editMappingForm" method="POST">
                @csrf
                @method('POST')

                <div class="modal-body">

                    <input type="hidden" name="auditor_id" id="edit-auditor-id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Auditor</label>
                        <input type="text" class="form-control" id="edit-auditor-name" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Unit Yang Ditugaskan</label>

                        <div class="border rounded p-3" style="max-height: 250px; overflow-y: auto;">
                            @foreach ($unit as $u)
                                <div class="form-check">
                                    <input class="form-check-input unit-checkbox" type="checkbox" value="{{ $u->id }}"
                                        id="unit-{{ $u->id }}" name="unit_ids[]">

                                    <label class="form-check-label" for="unit-{{ $u->id }}">
                                        {{ $u->nama_unit }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary w-100">Simpan</button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-mapping');
        const form = document.getElementById('editMappingForm');
        const nameField = document.getElementById('edit-auditor-name');
        const idField = document.getElementById('edit-auditor-id');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function () {

                const auditorId = this.dataset.id;
                const auditorName = this.dataset.nama;
                const existingUnits = this.dataset.units.split(',').map(Number);

                // set form action
                form.action = `/pemetaan_auditor/store`;

                // set auditor id
                idField.value = auditorId;
                nameField.value = auditorName;

                // reset all checkboxes
                document.querySelectorAll('.unit-checkbox').forEach(cb => cb.checked = false);

                // centang unit yang sudah dipetakan
                existingUnits.forEach(id => {
                    const cb = document.getElementById(`unit-${id}`);
                    if (cb) cb.checked = true;
                });
            });
        });

    });
</script>