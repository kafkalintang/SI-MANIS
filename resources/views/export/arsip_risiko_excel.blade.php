<table>
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center; font-weight:bold; border-left:3px solid #000;">No</th>
            <th colspan="15" style="text-align:center; font-weight:bold; border-left:3px solid #000;">Registrasi</th>
            <th colspan="3" style="text-align:center; font-weight:bold; border-left:3px solid #000;">Mitigasi</th>
            <th colspan="24" style="text-align:center; font-weight:bold; border-left:3px solid #000;">Evaluasi</th>
            <th colspan="2" style="text-align:center; font-weight:bold; border-left:3px solid #000;">Review Auditor</th>
        </tr>

        <tr>
            <!-- Registrasi -->
            <th style="text-align:center; font-weight:bold; border-left:3px solid #000;">Unit Kerja</th>
            <th style="text-align:center; font-weight:bold;">Proses/Aktifitas</th>
            <th style="text-align:center; font-weight:bold;">Kategori Risiko</th>
            <th style="text-align:center; font-weight:bold;">Jenis Risiko</th>
            <th style="text-align:center; font-weight:bold;">Isu/Risiko</th>
            <th style="text-align:center; font-weight:bold;">Jenis Isu</th>
            <th style="text-align:center; font-weight:bold;">Akar Permasalahan</th>
            <th style="text-align:center; font-weight:bold;">Dampak</th>
            <th style="text-align:center; font-weight:bold;">IKU Terkait</th>
            <th style="text-align:center; font-weight:bold;">Pihak Terkait</th>
            <th style="text-align:center; font-weight:bold;">Kontrol/Pencegahan</th>
            <th style="text-align:center; font-weight:bold;">Keparahan</th>
            <th style="text-align:center; font-weight:bold;">Frekuensi</th>
            <th style="text-align:center; font-weight:bold;">Probabilitas</th>
            <th style="text-align:center; font-weight:bold;">Status Registrasi</th>

            <!-- Mitigasi (kolom pertama diberi border tebal) -->
            <th style="text-align:center; font-weight:bold; border-left:3px solid #000;">Isu/Risiko</th>
            <th style="text-align:center; font-weight:bold;">Rencana Aksi</th>
            <th style="text-align:center; font-weight:bold;">Tanggal Tindak Lanjut</th>

            <!-- Evaluasi -->
            <!-- TW1 -->
            <th style="text-align:center; font-weight:bold; border-left:3px solid #000;">Triwulan 1</th>
            <th style="text-align:center; font-weight:bold;">Hasil Tindak Lanjut 1</th>
            <th style="text-align:center; font-weight:bold;">Tanggal Evaluasi 1</th>
            <th style="text-align:center; font-weight:bold;">Status Pelaksanaan 1</th>
            <th style="text-align:center; font-weight:bold;">Hasil Penerapan 1</th>
            <th style="text-align:center; font-weight:bold;">Bukti Dokumen 1</th>

            <!-- TW2 -->
            <th style="text-align:center; font-weight:bold;">Triwulan 2</th>
            <th style="text-align:center; font-weight:bold;">Hasil Tindak Lanjut 2</th>
            <th style="text-align:center; font-weight:bold;">Tanggal Evaluasi 2</th>
            <th style="text-align:center; font-weight:bold;">Status Pelaksanaan 2</th>
            <th style="text-align:center; font-weight:bold;">Hasil Penerapan 2</th>
            <th style="text-align:center; font-weight:bold;">Bukti Dokumen 2</th>

            <!-- TW3 -->
            <th style="text-align:center; font-weight:bold;">Triwulan 3</th>
            <th style="text-align:center; font-weight:bold;">Hasil Tindak Lanjut 3</th>
            <th style="text-align:center; font-weight:bold;">Tanggal Evaluasi 3</th>
            <th style="text-align:center; font-weight:bold;">Status Pelaksanaan 3</th>
            <th style="text-align:center; font-weight:bold;">Hasil Penerapan 3</th>
            <th style="text-align:center; font-weight:bold;">Bukti Dokumen 3</th>

            <!-- TW4 -->
            <th style="text-align:center; font-weight:bold;">Triwulan 4</th>
            <th style="text-align:center; font-weight:bold;">Hasil Tindak Lanjut 4</th>
            <th style="text-align:center; font-weight:bold;">Tanggal Evaluasi 4</th>
            <th style="text-align:center; font-weight:bold;">Status Pelaksanaan 4</th>
            <th style="text-align:center; font-weight:bold;">Hasil Penerapan 4</th>
            <th style="text-align:center; font-weight:bold;">Bukti Dokumen 4</th>

            <!-- Review Auditor -->
            <th style="text-align:center; font-weight:bold; border-left:3px solid #000;">Triwulan</th>
            <th style="text-align:center; font-weight:bold;">Catatan Hasil Review</th>
        </tr>
    </thead>

    <tbody>
        @php $no = 1; @endphp

        @foreach($registrasi as $item)

            @php
                // Ambil mitigasi pertama
                $mitigasi = $item->mitigasis->first();

                // Siapkan array evaluasi TW1–TW4
                $eval = [
                    1 => ['tw'=>'-','hasil'=>'-','tanggal'=>'-','status'=>'-','penerapan'=>'-','dokumen'=>'-'],
                    2 => ['tw'=>'-','hasil'=>'-','tanggal'=>'-','status'=>'-','penerapan'=>'-','dokumen'=>'-'],
                    3 => ['tw'=>'-','hasil'=>'-','tanggal'=>'-','status'=>'-','penerapan'=>'-','dokumen'=>'-'],
                    4 => ['tw'=>'-','hasil'=>'-','tanggal'=>'-','status'=>'-','penerapan'=>'-','dokumen'=>'-'],
                ];


                // Masukkan evaluasi sesuai TW
                if ($mitigasi) {
                    foreach ($mitigasi->evaluasis as $e) {
                        $tw = (int) $e->triwulan;
                        if ($tw >= 1 && $tw <= 4) {
                            $eval[$tw] = [
                                'tw'        => $e->triwulan . '-' . ($e->tahun ?? ''),
                                'hasil'     => $e->hasil_tindak_lanjut ?? '-',
                                'tanggal'   => $e->tanggal_evaluasi
                                                ? \Carbon\Carbon::parse($e->tanggal_evaluasi)->format('d M Y')
                                                : '-',
                                'status'    => $e->status_pelaksanaan ?? '-',
                                'penerapan' => $e->hasil_penerapan ?? '-',
                                'dokumen'   => $e->dokumen_pendukung ?? '-',
                            ];
                        }
                    }
                }

                // Ambil review auditor dari evaluasi TW berapa saja yang punya penilaian
                $review = null;

                if ($mitigasi) {
                    foreach ($mitigasi->evaluasis as $e) {
                        $pen = $e->penilaian->first();
                        if ($pen) {
                            // Simpan review TW terakhir + tahun
                            $review = (object)[
                                'tw'     => $e->triwulan . '-' . ($e->tahun ?? '-'),
                                'uraian' => $pen->uraian ?? '-',
                            ];
                        }
                    }
                }
            @endphp

            <tr>
                <!-- No -->
                <td style="text-align:center;">{{ $no++ }}</td>

                <!-- REGISTRASI -->
                <td style="border-left:3px solid #000;">{{ $item->unitKerja->nama_unit ?? '-' }}</td>
                <td>{{ $item->prosesAktivitas->nama_proses ?? '-' }}</td>
                <td>{{ $item->kategoriRisiko->nama_kategori ?? '-' }}</td>
                <td>{{ $item->jenisRisiko->nama_jenis ?? '-' }}</td>
                <td>{{ $item->isu_resiko }}</td>
                <td>{{ $item->jenis_isu }}</td>
                <td>{{ $item->akar_permasalahan }}</td>
                <td>{{ $item->dampak }}</td>
                <td>{{ $item->ikuTerkait->nama_iku ?? '-' }}</td>
                <td>{{ $item->pihak_terkait }}</td>
                <td>{{ $item->kontrol_pencegahan }}</td>
                <td>{{ $item->keparahan }}</td>
                <td>{{ $item->frekuensi }}</td>
                <td>{{ $item->probabilitas }}</td>
                <td>{{ $item->status_registrasi }}</td>

                <!-- MITIGASI -->
                <td style="border-left:3px solid #000;">{{ $mitigasi->isurisiko ?? '-' }}</td>
                <td>{{ $mitigasi->rencana_aksi ?? '-' }}</td>
                <td>{{ $mitigasi->tanggal_pelaksanaan
                        ? \Carbon\Carbon::parse($mitigasi->tanggal_pelaksanaan)->format('d M Y')
                        : '-' }}</td>

                <!-- EVALUASI TW1 -->
                <td style="border-left:3px solid #000;">{{ $eval[1]['tw'] }}</td>
                <td>{{ $eval[1]['hasil'] }}</td>
                <td>{{ $eval[1]['tanggal'] }}</td>
                <td>{{ $eval[1]['status'] }}</td>
                <td>{{ $eval[1]['penerapan'] }}</td>
                <td>{{ $eval[1]['dokumen'] }}</td>

                <!-- TW2 -->
                <td>{{ $eval[2]['tw'] }}</td>
                <td>{{ $eval[2]['hasil'] }}</td>
                <td>{{ $eval[2]['tanggal'] }}</td>
                <td>{{ $eval[2]['status'] }}</td>
                <td>{{ $eval[2]['penerapan'] }}</td>
                <td>{{ $eval[2]['dokumen'] }}</td>

                <!-- TW3 -->
                <td>{{ $eval[3]['tw'] }}</td>
                <td>{{ $eval[3]['hasil'] }}</td>
                <td>{{ $eval[3]['tanggal'] }}</td>
                <td>{{ $eval[3]['status'] }}</td>
                <td>{{ $eval[3]['penerapan'] }}</td>
                <td>{{ $eval[3]['dokumen'] }}</td>

                <!-- TW4 -->
                <td>{{ $eval[4]['tw'] }}</td>
                <td>{{ $eval[4]['hasil'] }}</td>
                <td>{{ $eval[4]['tanggal'] }}</td>
                <td>{{ $eval[4]['status'] }}</td>
                <td>{{ $eval[4]['penerapan'] }}</td>
                <td>{{ $eval[4]['dokumen'] }}</td>

                <!-- REVIEW AUDITOR -->
                <td style="border-left:3px solid #000;">
                    {{ $review->tw ?? '-' }}
                </td>
                <td>{{ $review->uraian ?? '-' }}</td>
            </tr>

        @endforeach
    </tbody>

</table>