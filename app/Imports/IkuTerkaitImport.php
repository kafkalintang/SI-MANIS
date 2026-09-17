<?php

namespace App\Imports;

use App\Models\IkuTerkait;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IkuTerkaitImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['iku_terkait']) || empty($row['iku_terkait'])) {
            return null;
        }

        // Cegah duplikasi berdasarkan kolom 'nama_unit'
        if (IkuTerkait::where('nama_iku', $row['iku_terkait'])->exists()) {
            return null;
        }

        // Simpan data baru
        return new IkuTerkait([
            'nama_iku' => $row['iku_terkait'],
        ]);
    }
}
