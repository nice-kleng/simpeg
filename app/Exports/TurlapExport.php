<?php

namespace App\Exports;

use App\Models\Marketing;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TurlapExport implements FromArray, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithCustomStartCell
{
    private $maxFollowUps;

    public function __construct()
    {
        $marketing = Marketing::with('followUp')->get();
        $this->maxFollowUps = $marketing->map(function ($item) {
            return $item->followUp->count();
        })->max();
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Nama',
            'Maps',
            'Rating',
            'Alamat',
            'No. Telp',
            'Tanggal',
            'Status Prospek',
            'PIC'
        ];

        for ($i = 0; $i < $this->maxFollowUps; $i++) {
            $headers[] = "Follow Up " . ($i + 1);
            $headers[] = "Keterangan FU " . ($i + 1);
        }

        return $headers;
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(9 + ($this->maxFollowUps * 2));

        // Title Style
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->setCellValue('A1', 'LAPORAN TURLAP MARKETING');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Headers Style
        $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Data Rows Style
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A3:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Set row height
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
    }

    public function columnWidths(): array
    {
        $data = $this->array();
        $widths = [];

        // Calculate width for each column based on content
        foreach ($data as $row) {
            foreach ($row as $colIndex => $value) {
                $contentLength = strlen(strval($value));
                if (!isset($widths[$colIndex]) || $contentLength > $widths[$colIndex]) {
                    $widths[$colIndex] = $contentLength;
                }
            }
        }

        // Convert numeric index to Excel column letters and adjust width
        $columnWidths = [];
        foreach ($widths as $index => $width) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $columnWidths[$column] = $width + 4; // Add padding
        }

        return $columnWidths;
    }

    public function title(): string
    {
        return 'Laporan Turlap';
    }

    public function array(): array
    {
        $marketings = Marketing::with('followUp')->get();
        $data = [];

        foreach ($marketings as $key => $marketing) {
            $row = [
                $key + 1,
                $marketing->nama,
                $marketing->maps,
                $marketing->rating,
                $marketing->alamat,
                $marketing->no_telp,
                $marketing->tanggal,
                $marketing->status_prospek,
                $marketing->pics->pluck('name')->implode(', ')
            ];

            // Add empty cells if follow-ups less than max
            $followUpsCount = $marketing->followUp->count();
            foreach ($marketing->followUp as $followUp) {
                $row[] = $followUp->tanggal;
                $row[] = $followUp->keterangan;
            }

            // Fill remaining cells with empty values
            for ($i = $followUpsCount; $i < $this->maxFollowUps; $i++) {
                $row[] = '';
                $row[] = '';
            }

            $data[] = $row;
        }

        return $data;
    }
}
