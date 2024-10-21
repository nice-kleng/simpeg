<?php

namespace App\Exports;

use App\Models\ReportTikTokLive;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportTikTokLiveExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($tanggalAwal, $tanggalAkhir)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tanggalAwal = \Carbon\Carbon::parse($this->tanggalAwal)->toDateString();
        $tanggalAkhir = \Carbon\Carbon::parse($this->tanggalAkhir)->toDateString();

        $query = ReportTikTokLive::whereDate('tanggal', '>=', $tanggalAwal)
            ->whereDate('tanggal', '<=', $tanggalAkhir);

        return $query->get()
            ->map(function ($item) {
                return [
                    $item->kd_report_tiktok_live,
                    $this->formatTanggal($item->tanggal),
                    $item->judul,
                    $item->waktu_mulai,
                    $item->durasi,
                    $item->total_tayangan,
                    $item->penonton_unik,
                    $item->rata_menonton,
                    $item->jumlah_penonton_teratas,
                    $item->pengikut,
                    $item->penonton_lainnya,
                    $item->pengikut_baru,
                    $item->penonton_berkomentar,
                    $item->suka,
                    $item->berbagi,
                    $item->pics->pluck('name')->implode(', '),
                ];
            });
    }

    private function formatTanggal($tanggal)
    {
        if (!$tanggal) return '';
        return \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM YYYY');
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Tanggal',
            'Judul',
            'Waktu Mulai',
            'Durasi',
            'Total Tayangan',
            'Penonton Unik',
            'Rata-rata Menonton',
            'Jumlah Penonton Teratas',
            'Pengikut',
            'Penonton Lainnya',
            'Pengikut Baru',
            'Penonton Berkomentar',
            'Suka',
            'Berbagi',
            'Pics',
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function title(): string
    {
        return 'Report TikTok Live';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->setCellValue('A1', 'Report TikTok Live');
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue('A2', $this->formatTanggal($this->tanggalAwal) . ' - ' . $this->formatTanggal($this->tanggalAkhir));
                $sheet->mergeCells("A3:{$lastColumn}3");

                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Header styling
                $headerRange = "A4:{$lastColumn}4";
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '4472C4']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Alternating row colors
                for ($row = 5; $row <= $lastRow; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'D9E1F2' : 'FFFFFF';
                    $sheet->getStyle("A{$row}:{$lastColumn}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadSheet\Style\Fill::FILL_SOLID,
                            'color' => ['rgb' => $fillColor],
                        ]
                    ]);
                }

                // Adjust column widths based on content
                $columnIterator = $sheet->getColumnIterator('A', $lastColumn);
                foreach ($columnIterator as $column) {
                    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
                }

                // Wrap text for all data cells
                $dataRange = "A5:{$lastColumn}{$lastRow}";
                $sheet->getStyle($dataRange)->getAlignment()->setWrapText(true);


                // Final adjustment to limit column width
                foreach ($sheet->getColumnIterator('A', $lastColumn) as $column) {
                    $colDimension = $sheet->getColumnDimension($column->getColumnIndex());
                    $currentWidth = $colDimension->getWidth();
                    $colDimension->setWidth(min($currentWidth, 20));
                }
            }
        ];
    }
}
