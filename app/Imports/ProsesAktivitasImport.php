<?php

namespace App\Imports;

use App\Models\ProsesAktivitas;
use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProsesAktivitasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // cek kolom proses
        if (!isset($row['proses_aktivitas']) || empty($row['proses_aktivitas'])) {
            return null;
        }

        // ambil unit_kerja dari nama
        $unitKerja = null;

        if (isset($row['unit_kerja']) && !empty($row['unit_kerja'])) {
            $unitKerja = UnitKerja::where('nama_unit', trim($row['unit_kerja']))->first();
        }

        // jika tidak ditemukan, skip
        if (!$unitKerja) {
            return null;
        }

        // cek duplikasi proses pada unit kerja tersebut
        if (ProsesAktivitas::where('nama_proses', $row['proses_aktivitas'])
            ->where('unit_kerja_id', $unitKerja->id)
            ->exists()) {
            return null;
        }

        // simpan
        return new ProsesAktivitas([
            'nama_proses' => trim($row['proses_aktivitas']),
            'unit_kerja_id' => $unitKerja->id,
        ]);
    }
}
