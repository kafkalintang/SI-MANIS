<?php

namespace App\Exports;

use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ProsesAktivitasExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TemplateSheet(),
            new UnitKerjaSheet(),
        ];
    }
}

class TemplateSheet implements FromArray, WithHeadings, WithTitle, WithEvents
{
    public function array(): array
    {
        // Buat 200 baris kosong
        $rows = [];
        for ($i = 0; $i < 200; $i++) {
            $rows[] = ['', ''];
        }
        return $rows;
    }

    public function headings(): array
    {
        return ['proses_aktivitas', 'unit_kerja'];
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

                // === HEADER STYLE ===
                $sheet->getStyle('A1:B1')->applyFromArray([
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
                        ],
                    ],
                ]);

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(28);

                // Auto width
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);

                // Freeze header
                $sheet->freezePane('A2');

                // === DROPDOWN UNIT KERJA ===
                $unitCount = UnitKerja::count();
                if ($unitCount === 0) return;

                $formula = "=UnitKerja!A2:A" . ($unitCount + 1);

                for ($row = 2; $row <= 201; $row++) {

                    $validation = $sheet->getCell("B{$row}")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowDropDown(true);

                    // Prompt saat cell diklik
                    $validation->setShowInputMessage(true);
                    $validation->setPromptTitle('Pilih Unit Kerja');
                    $validation->setPrompt('Silakan pilih unit kerja dari daftar dropdown.');

                    $validation->setFormula1($formula);
                }
            },
        ];
    }
}

class UnitKerjaSheet implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return UnitKerja::pluck('nama_unit')
            ->map(fn($u) => [$u])
            ->toArray();
    }

    public function headings(): array
    {
        return ['nama_unit'];
    }

    public function title(): string
    {
        return 'UnitKerja';
    }
}
