<?php

namespace App\Imports;

use App\Models\Registrasi;
use App\Models\UnitKerja;
use App\Models\ProsesAktivitas;
use App\Models\KategoriRisiko;
use App\Models\JenisRisiko;
use App\Models\IkuTerkait;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistrasiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    { 
        if (
            !isset($row['frekuensi']) || 
            !isset($row['keparahan']) ||
            empty($row['frekuensi']) || 
            empty($row['keparahan'])
        ) {
            return null; 
        }
        // Matriks Probabilitas
        $matrix = [
            'A' => [1 => 'Medium', 2 => 'High', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'B' => [1 => 'Low', 2 => 'Medium', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'C' => [1 => 'Low', 2 => 'Medium', 3 => 'Medium', 4 => 'Extreme', 5 => 'Extreme'],
            'D' => [1 => 'Low', 2 => 'Low', 3 => 'Medium', 4 => 'High', 5 => 'High'],
            'E' => [1 => 'Low', 2 => 'Low', 3 => 'Low', 4 => 'Medium', 5 => 'High'],
        ];
        $freq  = strtoupper(trim($row['frekuensi'] ?? ''));
        $sever = (int) ($row['keparahan'] ?? 0);

         $probabilitas = $matrix[$freq][$sever] ?? 'Low';

        // Return Data Ke Model
        $iku = IkuTerkait::where('nama_iku', $row['iku_terkait'])->value('id');
        if (!$iku) {
            throw new \Exception("IKU '{$row['iku_terkait']}' tidak ditemukan di database.");
        }

        $kategori = KategoriRisiko::where('nama_kategori', $row['kategori_risiko'])->value('id');
        if (!$kategori) {
            throw new \Exception("Kategori Risiko '{$row['kategori_risiko']}' tidak ditemukan.");
        }

        $jenis = JenisRisiko::where('nama_jenis', $row['jenis_risiko'])->value('id');
        if (!$jenis) {
            throw new \Exception("Jenis Risiko '{$row['jenis_risiko']}' tidak ditemukan.");
        }

        $proses = ProsesAktivitas::where('nama_proses', $row['proses_aktivitas'])->value('id');
        if (!$proses) {
            throw new \Exception("Proses '{$row['proses_aktivitas']}' tidak ditemukan.");
        }


        return new Registrasi([
            'unit_kerja_id' => Auth::user()->unit_kerja_id,  
            'proses_aktivitas_id' => $proses,
            'kategori_risiko_id' => $kategori,
            'jenis_risiko_id' => $jenis,
            'iku_terkait_id' => $iku,

            'isu_resiko' => $row['isu_resiko'],
            'jenis_isu' => $row['jenis_isu'],
            'akar_permasalahan' => $row['akar_permasalahan'],
            'dampak' => $row['dampak'],
            'pihak_terkait' => $row['pihak_terkait'],
            'kontrol_pencegahan' => $row['kontrol_pencegahan'],

            'keparahan' => $row['keparahan'],
            'frekuensi' => $row['frekuensi'],
            'probabilitas' => $probabilitas,

            'status_registrasi' => 'Belum Terverifikasi',
            'user_id' => Auth::id(),
        ]);
    }
}
