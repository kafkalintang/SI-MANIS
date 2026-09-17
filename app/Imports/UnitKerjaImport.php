<?php

namespace App\Imports;

use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitKerjaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['unit_kerja']) || empty($row['unit_kerja'])) {
            return null;
        }

        // Cegah duplikasi berdasarkan kolom 'nama_unit'
        if (UnitKerja::where('nama_unit', $row['unit_kerja'])->exists()) {
            return null;
        }

        // Simpan data baru
        return new UnitKerja([
            'nama_unit' => $row['unit_kerja'],
        ]);
    }
}
