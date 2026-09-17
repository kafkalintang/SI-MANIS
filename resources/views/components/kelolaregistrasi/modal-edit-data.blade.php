<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataLabel">Edit Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Form edit -->
                <form id="editForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="edit-method" value="PUT">
                    <input type="hidden" id="edit-id" name="id">

                    <!-- edit unit kerja -->
                    <div class="mb-4">
                        <label class="form-label">Unit Kerja</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->unitKerja->nama_unit }}"
                            disabled>

                        <input type="hidden" id="edit-unitkerja" name="unit_kerja_id"
                            value="{{ Auth::user()->unit_kerja_id }}">
                    </div>


                    <div class="mb-4">
                        <label class="form-label">Proses/Aktivitas</label>
                        <select class="form-select" id="edit_proses_aktivitas" name="proses_aktivitas_id" required>
                            <option value="" selected disabled>Pilih Proses/Aktivitas</option>

                            <!-- Opsi untuk tambah manual -->
                            <option value="manual">+ Tambah Proses Manual</option>

                            @foreach ($proses as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_proses }}</option>
                            @endforeach
                        </select>

                        <!-- Input manual muncul kalau pilih "manual" -->
                        <input type="text" class="form-control mt-2" id="edit_proses_manual_input" name="proses_manual"
                            placeholder="Masukkan proses baru" style="display:none;">
                    </div>



                    <div class="mb-4">
                        <label class="form-label">Kategori Risiko</label>
                        <select class="form-select" id="edit-kategori" name="kategori_risiko_id" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Jenis Risiko</label>
                        <select class="form-select" id="edit-jenis" name="jenis_risiko_id" required>
                            <option value="" selected disabled>Pilih Jenis Risiko</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isu / Risiko</label>
                        <input type="text" class="form-control" id="edit-isurisiko" name="isu_resiko" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Isu</label>
                        <select class="form-select" id="edit-jenisisu" name="jenis_isu" required>
                            <option value="" selected disabled>Pilih Jenis Isu</option>
                            <option value="Internal">Internal</option>
                            <option value="Eksternal">Eksternal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akar Permasalahan</label>
                        <input type="text" class="form-control" id="edit-akar" name="akar_permasalahan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dampak</label>
                        <input type="text" class="form-control" id="edit-dampak" name="dampak" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">IKU Terkait</label>
                        <select class="form-select" id="edit-iku" name="iku_terkait_id" required>
                            <option value="" selected disabled>Pilih IKU</option>
                            @foreach ($iku as $i)
                                <option value="{{ $i->id }}">{{ $i->nama_iku }} - {{ $i->deskripsi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pihak Terkait</label>
                        <input type="text" class="form-control" id="edit-pihak" name="pihak_terkait" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontrol/Pencegahan Saat Ini/Sistem Saat Ini</label>
                        <input type="text" class="form-control" id="edit-kontrol" name="kontrol_pencegahan" required>
                    </div>

                    <div class="mb-3">
                        <label for="keparahan" class="me-2 fw-medium">Keparahan</label>
                        <select id="edit-keparahan" name="keparahan" class="form-select form-select-sm"
                            style="min-width: 70px; padding-right: 24px;">
                            <option value="1">1. Tidak Signifikan (dampaknya hanya di area tersebut)</option>
                            <option value="2">2. Kecil (Dampaknya sampai satu bagian/departemen)"</option>
                            <option value="3">3. Sedang (Dampaknya sampai satu institusi)</option>
                            <option value="4">4. Besar (Akibatnya sampai ke customer)</option>
                            <option value="5">5. Bencana (Dampaknya sampai ke pemerintah dan atau Customer)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="frekuensi" class="me-2 fw-medium">Frekuensi</label>
                        <select id="edit-frekuensi" name="frekuensi" class="form-select form-select-sm"
                            style="min-width: 70px; padding-right: 24px;">
                            <option value="A">A. Hampir Pasti (Beberapa kali tiap peristiwa/ tiap hari terjadi)
                            </option>
                            <option value="B">B. Mungkin Sekali (>1 kali tiap bulan)</option>
                            <option value="C">C. Mungkin (Dalam Setahun ada 1- 5 kali)</option>
                            <option value="D">D. Jarang (Dalam setahun hanya 1 kali)</option>
                            <option value="E">E. Sangat Jarang (Hampir tidak pernah terjadi, dalam 5 tahun hanya 1
                                kali)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('edit_proses_aktivitas').addEventListener('change', function () {
        let manual = document.getElementById('edit_proses_manual_input');
        manual.style.display = (this.value === 'manual') ? 'block' : 'none';

        if (this.value !== 'manual') {
            manual.value = "";
        }
    });
</script>