<?php

namespace App\Imports;

use App\Models\JenisRisiko;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisRisikoImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['jenis_risiko']) || empty($row['jenis_risiko'])) {
            return null;
        }

        // Cegah duplikasi berdasarkan kolom 'nama_unit'
        if (JenisRisiko::where('nama_jenis', $row['jenis_risiko'])->exists()) {
            return null;
        }

        // Simpan data baru
        return new JenisRisiko([
            'nama_jenis' => $row['jenis_risiko'],
        ]);
    }
}
