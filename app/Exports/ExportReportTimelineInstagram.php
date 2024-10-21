<?php

namespace App\Exports;

use App\Models\ReportTimelineInstagram;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportReportTimelineInstagram implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $jenis_project;

    public function __construct($tanggalAwal, $tanggalAkhir, $jenis_project = null)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->jenis_project = $jenis_project;
    }

    public function collection()
    {
        $tanggalAwal = Carbon::parse($this->tanggalAwal)->toDateString();
        $tanggalAkhir = Carbon::parse($this->tanggalAkhir)->toDateString();

        $query = ReportTimelineInstagram::whereHas('timelineInstagram', function ($query) use ($tanggalAwal, $tanggalAkhir) {
            $query->whereDate('tanggal', '>=', $tanggalAwal)
                ->whereDate('tanggal', '<=', $tanggalAkhir);

            if ($this->jenis_project) {
                $query->where('jenis_project', $this->jenis_project);
            }
        })
            ->with('timelineInstagram');

        return $query->get()
            ->map(function ($item) {
                return [
                    // Kolom-kolom dari TimelineInstagram
                    $item->timelineInstagram->kd_timelineig ?? '',
                    $this->formatTanggal($item->timelineInstagram->tanggal),
                    $item->timelineInstagram->jenis_project ?? '',
                    $item->timelineInstagram->status ?? '',
                    $item->timelineInstagram->format ?? '',
                    $item->timelineInstagram->jenis_konten ?? '',
                    $item->timelineInstagram->produk ?? '',
                    $item->timelineInstagram->head_term ?? '',
                    $item->timelineInstagram->core_topic ?? '',
                    $item->timelineInstagram->subtopic ?? '',
                    $item->timelineInstagram->copywriting ?? '',
                    $item->timelineInstagram->notes ?? '',
                    $item->timelineInstagram->refrensi ?? '',
                    $item->timelineInstagram->pics->pluck('name')->implode(', ') ?? '',

                    // Kolom-kolom dari ReportTimelineInstagram
                    $item->jangkauan,
                    $item->interaksi,
                    $item->aktivitas,
                    $item->impresi,
                    $item->like,
                    $item->comment,
                    $item->share,
                    $item->save,
                    $item->pengikut,
                    $item->bukan_pengikut,
                    $item->profile,
                    $item->beranda,
                    $item->jelajahi,
                    $item->lainnya,
                    $item->tagar,
                    $item->jumlah_pemutaran,
                    $item->waktu_tonton,
                    $item->rata,
                    $item->link_konten,
                ];
            });
    }

    private function formatTanggal($tanggal)
    {
        if (!$tanggal) return '';
        return Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM YYYY');
    }

    public function headings(): array
    {
        return [
            // Header untuk kolom-kolom TimelineInstagram
            'Kode',
            'Tanggal',
            'Jenis Project',
            'Status',
            'Format',
            'Jenis Konten',
            'Produk',
            'Head Term',
            'Core Topic',
            'Subtopic',
            'Copywriting',
            'Notes',
            'Refrensi',
            'Pics',

            // Header untuk kolom-kolom ReportTimelineInstagram
            'Jangkauan',
            'Interaksi',
            'Aktivitas',
            'Impresi',
            'Like',
            'Comment',
            'Share',
            'Save',
            'Pengikut',
            'Bukan Pengikut',
            'Profile',
            'Beranda',
            'Jelajahi',
            'Lainnya',
            'Tagar',
            'Jumlah Pemutaran',
            'Waktu Tonton',
            'Rata-rata',
            'Link Konten',
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return 'Report Timeline Instagram';
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
                $sheet->setCellValue('A1', 'Report Timeline Instagram');
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue('A2', $this->formatTanggal($this->tanggalAwal) . ' - ' . $this->formatTanggal($this->tanggalAkhir));
                $sheet->mergeCells("A3:{$lastColumn}3");
                $sheet->setCellValue('A3', 'Jenis Project : ' . ($this->jenis_project ?? 'All Project'));
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
