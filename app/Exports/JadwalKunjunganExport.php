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

class JadwalKunjunganExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithMapping, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $janjiTemu;
    protected $tanggal;
    protected $totalKunjungan;
    protected $statusCount;

    public function __construct($janjiTemu, $tanggal, $totalKunjungan, $statusCount)
    {
        $this->janjiTemu = $janjiTemu;
        $this->tanggal = $tanggal;
        $this->totalKunjungan = $totalKunjungan;
        $this->statusCount = $statusCount;
    }

    public function collection()
    {
        return $this->janjiTemu;
    }

    public function startCell(): string
    {
        return 'A9';
    }

    public function headings(): array
    {
        return [
            'No',
            'Pasien',
            'Dokter',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Status'
        ];
    }

    public function map($jt): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $jt->pasien->user->nama_lengkap ?? '-',
            $jt->dokter->user->nama_lengkap ?? '-',
            Carbon::parse($jt->tanggal)->format('d/m/Y'),
            Carbon::parse($jt->jam_mulai)->format('H:i'),
            Carbon::parse($jt->jam_selesai)->format('H:i'),
            ucfirst($jt->status),
        ];
    }

    public function title(): string
    {
        return 'Jadwal Kunjungan';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 25,
            'D' => 15,
            'E' => 12,
            'F' => 12,
            'G' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            9 => [
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
                $sheet->setCellValue('A1', 'LAPORAN JADWAL KUNJUNGAN');
                $sheet->setCellValue('A2', 'DentaTime - Sistem Manajemen Klinik Gigi');
                $sheet->setCellValue('A3', 'Tanggal: ' . Carbon::parse($this->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY'));
                $sheet->setCellValue('A5', 'STATISTIK');
                $sheet->setCellValue('A6', 'Total Kunjungan: ' . $this->totalKunjungan);
                $sheet->setCellValue('A7', 'Pending: ' . $this->statusCount['pending'] . ' | Confirmed: ' . $this->statusCount['confirmed'] . ' | Completed: ' . $this->statusCount['completed'] . ' | Canceled: ' . $this->statusCount['canceled']);
                
                // Merge cells untuk header
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A7:G7');
                
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
                $sheet->getStyle('A9:G9')->applyFromArray([
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
                if ($lastRow >= 10) {
                    $sheet->getStyle('A9:G' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]);
                    
                    // Center alignment untuk beberapa kolom
                    $sheet->getStyle('A10:A' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    $sheet->getStyle('D10:D' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    $sheet->getStyle('E10:F' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    $sheet->getStyle('G10:G' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }
            },
        ];
    }
}
