<?php

namespace App\Exports;

use App\Models\ProsesAktivitas;
use App\Models\KategoriRisiko;
use App\Models\JenisRisiko;
use App\Models\IkuTerkait;
use Illuminate\Support\Facades\Auth;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class RegistrasiExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TemplateSheet(),
            new ProsesSheet(),
            new KategoriSheet(),
            new JenisSheet(),
            new IkuSheet(),
        ];
    }
}

/*
|--------------------------------------------------------------------------
| SHEET 1 - TEMPLATE (UNTUK USER ISI)
|--------------------------------------------------------------------------
*/
class TemplateSheet implements FromArray, WithHeadings, WithTitle, WithEvents
{
    public function array(): array
    {
        return [
            ['']  // kosong
        ];
    }

    public function headings(): array
    {
        return [
            'proses_aktivitas',
            'kategori_risiko',
            'jenis_risiko',
            'iku_terkait',
            'isu_resiko',
            'jenis_isu',
            'akar_permasalahan',
            'dampak',
            'pihak_terkait',
            'kontrol_pencegahan',
            'keparahan',
            'frekuensi',
        ];
    }

    public function title(): string
    {
        return 'Template';
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // === DROP DOWN ===
            $this->dropdown($sheet, 'A', 'Proses');
            $this->dropdown($sheet, 'B', 'Kategori');
            $this->dropdown($sheet, 'C', 'Jenis');
            $this->dropdown($sheet, 'D', 'IKU');

            $this->staticDropdown($sheet, 'F', ['Internal','Eksternal']);
            $this->staticDropdown($sheet, 'K', ['1','2','3','4','5']);
            $this->staticDropdown($sheet, 'L', ['A','B','C','D','E']);

            // === STYLING HEADER ===
            $sheet->getStyle('A1:L1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4F81BD'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

            // Tinggi baris header
            $sheet->getRowDimension(1)->setRowHeight(30);
            $sheet->getColumnDimension('D')->setWidth(35);

            // Auto width semua kolom
            foreach (range('A', 'L') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Freeze header row
            $sheet->freezePane('A2');

            // Wrap text kolom panjang
            $wrapCols = ['E','G','H','I','J'];
            foreach ($wrapCols as $col) {
                $sheet->getStyle("{$col}:{$col}")
                      ->getAlignment()
                      ->setWrapText(true);
            }
        }
    ];
}




private function dropdown($sheet, $column, $sheetName)
{
    $validation = $sheet->getCell("{$column}2")->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setShowDropDown(true);
    $validation->setAllowBlank(false);

    // sumber dropdown (sheet lain)
    $validation->setFormula1("={$sheetName}!A:A");

    // === Tambahan: Pesan muncul saat klik dropdown ===
    $validation->setShowInputMessage(true);
    $validation->setPromptTitle("Pilih {$sheetName}");
    $validation->setPrompt("Silakan pilih salah satu daftar {$sheetName} yang tersedia.");

    for ($i = 2; $i <= 200; $i++) {
        $sheet->getCell("{$column}{$i}")
            ->setDataValidation(clone $validation);
    }
}


private function staticDropdown($sheet, $column, array $values)
{
    $list = '"' . implode(',', $values) . '"';

    // Base validation
    $validation = $sheet->getCell("{$column}2")->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setShowDropDown(true);
    $validation->setAllowBlank(false);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);

    // ⬅ Pesan ketika data salah
    $validation->setErrorTitle('Input Tidak Valid');
    $validation->setError('Silakan pilih dari daftar dropdown.');

    // ⬅ Pesan saat user klik cell
    $validation->setShowInputMessage(true);
    $validation->setPromptTitle('Pilih Nilai');
    $validation->setPrompt('Silakan pilih salah satu dari dropdown.');

    // Isi dropdown list
    $validation->setFormula1($list);

    // Apply ke 200 baris
    for ($i = 2; $i <= 200; $i++) {
        $sheet->getCell("{$column}{$i}")
              ->setDataValidation(clone $validation);
    }
}


}

/*
|--------------------------------------------------------------------------
| MASTER DROPDOWN SHEETS
|--------------------------------------------------------------------------
*/

class ProsesSheet implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;

        return ProsesAktivitas::where('unit_kerja_id', $unitKerjaId)
            ->pluck('nama_proses')
            ->map(fn($v) => [$v])
            ->toArray();
    }

    public function headings(): array
    {
        return ['nama_proses'];
    }

    public function title(): string
    {
        return 'Proses';
    }
}

class KategoriSheet implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return KategoriRisiko::pluck('nama_kategori')
            ->map(fn($v) => [$v])
            ->toArray();
    }

    public function headings(): array
    {
        return ['nama_kategori'];
    }

    public function title(): string
    {
        return 'Kategori';
    }
}

class JenisSheet implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return JenisRisiko::pluck('nama_jenis')
            ->map(fn($v) => [$v])
            ->toArray();
    }

    public function headings(): array
    {
        return ['nama_jenis'];
    }

    public function title(): string
    {
        return 'Jenis';
    }
}

class IkuSheet implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return IkuTerkait::pluck('nama_iku')
            ->map(fn($v) => [$v])
            ->toArray();
    }

    public function headings(): array
    {
        return ['nama_iku'];
    }

    public function title(): string
    {
        return 'IKU';
    }
}
