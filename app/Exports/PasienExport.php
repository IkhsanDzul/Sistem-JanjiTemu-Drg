<?php

namespace App\Exports;

use App\Models\Pasien;
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
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class PasienExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithMapping, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $pasien;
    protected $totalPasien;
    protected $pasienLaki;
    protected $pasienPerempuan;

    public function __construct($pasien, $totalPasien, $pasienLaki, $pasienPerempuan)
    {
        $this->pasien = $pasien;
        $this->totalPasien = $totalPasien;
        $this->pasienLaki = $pasienLaki;
        $this->pasienPerempuan = $pasienPerempuan;
    }

    public function collection()
    {
        return $this->pasien;
    }

    public function startCell(): string
    {
        return 'A10';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Jenis Kelamin',
            'Tanggal Daftar'
        ];
    }

    public function map($p): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $p->user->nama_lengkap ?? '-',
            $p->user->email ?? '-',
            $p->user->nomor_telp ?? '-',
            $p->user->jenis_kelamin ?? '-',
            $p->user->created_at ? Carbon::parse($p->user->created_at)->format('d/m/Y') : '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Pasien';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 30,
            'D' => 15,
            'E' => 15,
            'F' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            2 => [
                'font' => ['size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            3 => [
                'font' => ['size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            5 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
            10 => [
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
                $sheet->setCellValue('A1', 'LAPORAN JUMLAH PASIEN TERDAFTAR');
                $sheet->setCellValue('A2', 'DentaTime - Sistem Manajemen Klinik Gigi');
                $sheet->setCellValue('A3', 'Tanggal Laporan: ' . Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'));
                $sheet->setCellValue('A5', 'STATISTIK');
                $sheet->setCellValue('A6', 'Total Pasien: ' . $this->totalPasien);
                $sheet->setCellValue('A7', 'Pasien Laki-laki: ' . $this->pasienLaki);
                $sheet->setCellValue('A8', 'Pasien Perempuan: ' . $this->pasienPerempuan);
                
                // Merge cells untuk header
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                
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
                $sheet->getStyle('A10:F10')->applyFromArray([
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
                if ($lastRow >= 11) {
                    $sheet->getStyle('A10:F' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]);
                    
                    // Center alignment untuk kolom No
                    $sheet->getStyle('A11:A' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    
                    // Center alignment untuk kolom Jenis Kelamin
                    $sheet->getStyle('E11:E' . $lastRow)->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }
            },
        ];
    }
}
