<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModalProsesAktivitas" tabindex="-1"
     aria-labelledby="tambahDataLabelProsesAktivitas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabelProsesAktivitas">Tambah Proses/Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('proses.store') }}" method="POST">
                @csrf
                <input type="hidden" name="modal" value="tambahProses">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="proses" class="form-label">Proses/Aktivitas</label>
                        <input type="text"
                            class="form-control @error('proses') is-invalid @enderror"
                            id="proses"
                            name="proses"
                            value="{{ old('proses') }}"
                            required>

                        @error('proses')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <!-- Field Unit Kerja -->
                     <div class="mb-3">
                        <label for="unit_kerja_id" class="form-label">Unit Kerja</label>
                        <select name="unit_kerja_id" class="form-control" required>
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach ($allUnitKerja as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                        
                        
                        @error('unit_kerja_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any() && old('modal') === 'tambahProses')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tambahModal = new bootstrap.Modal(document.getElementById('tambahDataModalProsesAktivitas'));
        tambahModal.show();
    });
</script>
@endif
