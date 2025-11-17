<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class DokterAktifExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithMapping, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $dokter;
    protected $totalDokter;

    public function __construct($dokter, $totalDokter)
    {
        $this->dokter = $dokter;
        $this->totalDokter = $totalDokter;
    }

    public function collection()
    {
        return $this->dokter;
    }

    public function startCell(): string
    {
        return 'A8';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dokter',
            'Email',
            'Spesialisasi',
            'Pengalaman',
            'No. STR',
            'Total Janji Temu',
            'Janji Temu Bulan Ini'
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;
        $d = $item['dokter'];
        return [
            $no,
            $d->user->nama_lengkap ?? '-',
            $d->user->email ?? '-',
            $d->spesialisasi_gigi ?? '-',
            ($d->pengalaman_tahun ?? 0) . ' tahun',
            $d->no_str ?? '-',
            $item['total_janji_temu'],
            $item['janji_temu_bulan_ini'],
        ];
    }

    public function title(): string
    {
        return 'Dokter Aktif';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 30,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 18,
            'H' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            8 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '005248'],
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Tambahkan header laporan
                $sheet->setCellValue('A1', 'LAPORAN DAFTAR DOKTER AKTIF');
                $sheet->setCellValue('A2', 'DentaTime - Sistem Manajemen Klinik Gigi');
                $sheet->setCellValue('A3', 'Tanggal Laporan: ' . Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'));
                $sheet->setCellValue('A5', 'STATISTIK');
                $sheet->setCellValue('A6', 'Total Dokter Aktif: ' . $this->totalDokter);
                
                // Merge cells untuk header
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');
                
                // Style untuk header
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                
                $sheet->getStyle('A5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                ]);
                
                // Style untuk header table
                $sheet->getStyle('A8:H8')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '005248'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
                
                // Border untuk semua data
                $lastRow = $sheet->getHighestRow();
                if ($lastRow >= 9) {
                    $sheet->getStyle('A8:H' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]);
                    
                    // Center alignment untuk beberapa kolom
                    $sheet->getStyle('A9:A' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    $sheet->getStyle('E9:E' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    $sheet->getStyle('G9:H' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }
            },
        ];
    }
}
