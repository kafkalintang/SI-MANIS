<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabel">Tambah Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('registrasi.store') }}" method="POST">
                    @csrf

                    <!-- Unit Kerja -->
                    <div class="mb-4">
                        <label class="form-label">Unit Kerja</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->unitKerja->nama_unit }}"
                            disabled>

                        <input type="hidden" name="unit_kerja_id" value="{{ Auth::user()->unit_kerja_id }}">
                    </div>

                    <!-- Proses/Aktivitas (Dropdown + Manual Input) -->
                    <div class="mb-4">
                    <label class="form-label">Proses/Aktivitas</label>
                    <select id="proses_aktivitas" name="proses_aktivitas_id" class="form-select">
                        <option value="" disabled selected>-- Pilih Proses/Aktivitas --</option>
                        <option value="manual">+ Tambah Proses Manual</option>
                        @foreach ($proses as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_proses }}</option>
                        @endforeach
                    </select>

                    <input type="text"
                        id="proses_manual_input"
                        name="proses_manual"
                        class="form-control mt-2"
                        placeholder="Masukkan proses baru"
                        style="display:none;">
                    </div>


                    <!-- Kategori Risiko -->
                    <div class="mb-4">
                        <label class="form-label">Kategori Risiko</label>
                        <select name="kategori_risiko_id" class="form-select" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Risiko -->
                    <div class="mb-4">
                        <label class="form-label">Jenis Risiko</label>
                        <select name="jenis_risiko_id" class="form-select" required>
                            <option value="" selected disabled>Pilih Jenis Risiko</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Isu Risiko -->
                    <div class="mb-3">
                        <label class="form-label">Isu / Risiko</label>
                        <input type="text" name="isu_resiko" class="form-control" required>
                    </div>

                    <!-- Jenis Isu -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Isu</label>
                        <select name="jenis_isu" class="form-select" required>
                            <option value="" selected disabled>Pilih Jenis Isu</option>
                            <option value="Internal">Internal</option>
                            <option value="Eksternal">Eksternal</option>
                        </select>
                    </div>

                    <!-- Akar Permasalahan -->
                    <div class="mb-3">
                        <label class="form-label">Akar Permasalahan</label>
                        <input type="text" name="akar_permasalahan" class="form-control" required>
                    </div>

                    <!-- Dampak -->
                    <div class="mb-3">
                        <label class="form-label">Dampak</label>
                        <input type="text" name="dampak" class="form-control" required>
                    </div>

                    <!-- IKU -->
                    <div class="mb-3">
                        <label class="form-label">IKU terkait</label>
                        <select name="iku_terkait_id" class="form-select" required>
                            <option value="" selected disabled>Pilih IKU</option>
                            @foreach ($iku as $i)
                                <option value="{{ $i->id }}">{{ $i->nama_iku }} - {{ $i->deskripsi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pihak Terkait -->
                    <div class="mb-3">
                        <label class="form-label">Pihak Terkait</label>
                        <input type="text" name="pihak_terkait" class="form-control" required>
                    </div>

                    <!-- Kontrol Pencegahan -->
                    <div class="mb-3">
                        <label class="form-label">Kontrol/Pencegahan Saat Ini/Sistem Saat Ini</label>
                        <input type="text" name="kontrol_pencegahan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="keparahan" class="me-2 fw-medium">Keparahan</label>
                        <select id="keparahan" name="keparahan" class="form-select form-select-sm"
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
                        <select id="frekuensi" name="frekuensi" class="form-select form-select-sm"
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

                    <button type="submit" class="btn btn-primary w-100"></i>Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('proses_aktivitas').addEventListener('change', function() {
        let manual = document.getElementById('proses_manual_input');
        manual.style.display = (this.value === 'manual') ? 'block' : 'none';
    });
    </script>