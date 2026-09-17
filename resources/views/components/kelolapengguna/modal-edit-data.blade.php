<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabel">Edit Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="edit-nik" name="nik" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-unit" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="edit-unit" name="role1">
                            <option value="" selected disabled>Pilih Unit Kerja</option>
                            @foreach ($unitKerja as $unit)
                                <option value="{{ $unit->id }}"
                                    data-key="{{ strtolower($unit->kode ?? $unit->nama_unit) }}">{{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.9rem; color: red; margin-top: 5px;">
                            *Kosongkan kolom Unit Kerja jika pengguna hanya memiliki peran sebagai Auditor.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <div id="role-checkboxes">
                            <div class="form-check">
                                <input class="form-check-input role-checkbox" type="checkbox" name="roles[]" value="p4m"
                                    id="role-p4m">
                                <label class="form-check-label" for="role-p4m">P4M</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input role-checkbox" type="checkbox" name="roles[]"
                                    value="kepala_unit" id="role-kepala_unit">
                                <label class="form-check-label" for="role-kepala_unit">Kepala Unit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input role-checkbox" type="checkbox" name="roles[]"
                                    value="auditor" id="role-auditor">
                                <label class="form-check-label" for="role-auditor">Auditor</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const editButtons = document.querySelectorAll('.edit-button');
        const editForm = document.getElementById('editForm');
        const unitSelect = document.getElementById('edit-unit');
        const roleCheckboxes = Array.from(
            document.querySelectorAll('#editDataModal .role-checkbox')
        );

        function setRoleCheckboxes(allowedValues) {
            roleCheckboxes.forEach(cb => {
                const allowed = allowedValues.includes(cb.value);
                cb.disabled = !allowed;

                if (!allowed && cb.checked) cb.checked = false;
            });
        }

        function allowedRolesForUnit(unitName) {
            if (!unitName) return ['auditor'];

            const name = unitName.toLowerCase();

            if (name.includes('p4m')) return ['p4m', 'auditor'];     // <--- PERUBAHAN DI SINI
            if (name.includes('manajemen')) return ['kepala_unit', 'auditor'];

            return ['kepala_unit', 'auditor'];
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function () {

                const id = this.getAttribute('data-id');
                const nik = this.getAttribute('data-nik');
                const nama = this.getAttribute('data-nama');
                const unit = this.getAttribute('data-unit');
                const role = this.getAttribute('data-role');

                editForm.action = `/kelola_pengguna/update/${id}`;
                document.getElementById('edit-nik').value = nik;
                document.getElementById('edit-nama').value = nama;
                document.getElementById('edit-unit').value = unit ?? '';

                const rolesToCheck = role ? role.split(',').map(r => r.trim()) : [];

                roleCheckboxes.forEach(cb => {
                    cb.checked = rolesToCheck.includes(cb.value);
                });

                const selectedText =
                    unitSelect.options[unitSelect.selectedIndex]?.text || '';

                setRoleCheckboxes(allowedRolesForUnit(selectedText));
            });
        });

        unitSelect.addEventListener('change', function () {
            const selectedText =
                this.options[this.selectedIndex]?.text || '';

            setRoleCheckboxes(allowedRolesForUnit(selectedText));
        });
    });
</script>