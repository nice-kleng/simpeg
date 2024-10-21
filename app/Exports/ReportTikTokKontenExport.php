<?php

namespace App\Exports;

use App\Models\ReportTikTok;
use App\Models\TimelineTiktok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

// use Maatwebsite\Excel\Events\AfterSheet;

class ReportTikTokKontenExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithEvents
{
    protected $tanggalAwal, $tanggalAkhir, $tipeKonten;

    public function __construct($tanggalAwal, $tanggalAkhir, $tipeKonten = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->tipeKonten = $tipeKonten;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = TimelineTiktok::with('report')
            ->whereHas('report')
            ->when($this->tanggalAwal && $this->tanggalAkhir, function ($query) {
                return $query->whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir]);
            })
            ->when($this->tipeKonten, function ($query) {
                return $query->where('tipe_konten', $this->tipeKonten);
            });

        return $query->get()
            ->map(function ($item) {
                return [
                    $item->kd_timeline_tiktok ?? '',
                    $this->formatTanggal($item->tanggal),
                    $item->tipe_konten ?? '',
                    $item->jenis_konten ?? '',
                    $item->produk ?? '',
                    $item->hook_konten ?? '',
                    $item->copywriting ?? '',
                    $item->jam_upload ?? '',
                    $item->report->views ?? '',
                    $item->report->like ?? '',
                    $item->report->comment ?? '',
                    $item->report->share ?? '',
                    $item->report->save ?? '',
                    $item->report->usia_18_24 ?? '',
                    $item->report->usia_25_34 ?? '',
                    $item->report->usia_35_44 ?? '',
                    $item->report->usia_45_54 ?? '',
                    $item->report->gender_pria ?? '',
                    $item->report->gender_wanita ?? '',
                    $item->report->total_pemutaran ?? '',
                    $item->report->rata_menonton ?? '',
                    $item->report->view_utuh ?? '',
                    $item->report->pengikut_baru ?? '',
                    $item->report->link_konten ?? '',
                    $item->pics->pluck('name')->implode(', ') ?? '',
                ];
            });
    }

    protected function formatTanggal($tanggal)
    {
        if (!$tanggal) return '';
        return \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM YYYY');
    }

    public function headings(): array
    {
        return [
            'Kode Timeline TikTok',
            'Tanggal',
            'Tipe Konten',
            'Jenis Konten',
            'Produk',
            'Hook Konten',
            'Copywriting',
            'Jam Upload',
            'Views',
            'Like',
            'Comment',
            'Share',
            'Save',
            'Usia 18-24',
            'Usia 25-34',
            'Usia 35-44',
            'Usia 45-54',
            'Gender Pria',
            'Gender Wanita',
            'Total Pemutaran',
            'Rata-rata Menonton',
            'View Utuh',
            'Pengikut Baru',
            'Link Konten',
            'Pics',
        ];
    }

    public function title(): string
    {
        return 'Report TikTok';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                // Title and date range styling
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->setCellValue('A1', 'Report TikTok');
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue('A2', $this->formatTanggal($this->tanggalAwal) . ' - ' . $this->formatTanggal($this->tanggalAkhir));
                $sheet->mergeCells("A3:{$lastColumn}3");
                $sheet->setCellValue('A3', 'Jenis Project : ' . ($this->tipeKonten ?? 'All Project'));
                $sheet->mergeCells("A4:{$lastColumn}4");

                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Header styling
                $headerRange = "A5:{$lastColumn}5";
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '4472C4']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Data styling
                $dataRange = "A6:{$lastColumn}{$lastRow}";
                $sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ]);

                // Alternating row colors
                for ($row = 6; $row <= $lastRow; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'D9E1F2' : 'FFFFFF';
                    $sheet->getStyle("A{$row}:{$lastColumn}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['rgb' => $fillColor],
                        ],
                    ]);
                }

                // Adjust column widths based on content
                $columnIterator = $sheet->getColumnIterator('A', $lastColumn);
                foreach ($columnIterator as $column) {
                    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
                }

                // Wrap text for all data cells
                $sheet->getStyle($dataRange)->getAlignment()->setWrapText(true);

                // Final adjustment to limit column width
                foreach ($sheet->getColumnIterator('A', $lastColumn) as $column) {
                    $colDimension = $sheet->getColumnDimension($column->getColumnIndex());
                    $currentWidth = $colDimension->getWidth();
                    $colDimension->setWidth(min($currentWidth, 50));
                }
            },
        ];
    }
}
