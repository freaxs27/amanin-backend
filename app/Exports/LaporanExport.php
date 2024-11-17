<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Import this
use Maatwebsite\Excel\Sheet;

class LaporanExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithTitle
{
    public function collection()
    {
        return Laporan::all();  // Mengambil seluruh data Laporan
    }

    public function headings(): array
    {
        return [
            'ID', 'Title', 'Description','Image' ,'Status', 'Created At', 'Updated At'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 50,
            'D' => 15,
            'E' => 20,
            'F' => 20,
        ];
    }

    // Update this method to use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as the parameter
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],  // Bold for header
            'A1:F1' => [
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
                'font' => [
                    'color' => ['argb' => 'FFFFFF'],
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => '4CAF50'],  // Green background
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Data';  // Nama sheet Excel
    }
}

