<?php

namespace App\Imports;

use App\Models\KategoriRisiko;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriRisikoImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kategori_risiko']) || empty($row['kategori_risiko'])) {
            return null;
        }

        // Cegah duplikasi berdasarkan kolom 'nama_unit'
        if (KategoriRisiko::where('nama_kategori', $row['kategori_risiko'])->exists()) {
            return null;
        }

        // Simpan data baru
        return new KategoriRisiko([
            'nama_kategori' => $row['kategori_risiko'],
        ]);
    }
}
