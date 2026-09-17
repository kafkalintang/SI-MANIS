<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kelola_pengguna.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="role1" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="role1" name="role1">
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
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('role1'); // unit_kerja select
    const checkboxes = Array.from(document.querySelectorAll('.role-checkbox'));

    function setRoleCheckboxes(allowedValues) {
        checkboxes.forEach(cb => {
            const allowed = allowedValues.includes(cb.value);
            cb.disabled = !allowed;

            // if a checkbox is disabled and checked -> uncheck
            if (!allowed && cb.checked) cb.checked = false;
        });
    }

    function allowedRolesForUnit(unitName) {
        if (!unitName) return ['auditor']; 
        const name = unitName.toLowerCase();
        if (name.includes('p4m')) return ['p4m', 'auditor'];
        if (name.includes('manajemen')) return ['kepala_unit', 'auditor'];
        return ['kepala_unit', 'auditor'];
    }

    
    (function init() {
        const selectedUnitText = unitSelect.options[unitSelect.selectedIndex]?.text || '';
        setRoleCheckboxes(allowedRolesForUnit(selectedUnitText));
    })();

    unitSelect.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex]?.text || '';
        setRoleCheckboxes(allowedRolesForUnit(selectedText));
    });
});
</script>
