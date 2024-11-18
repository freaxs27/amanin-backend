<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; 
use Maatwebsite\Excel\Sheet;
use Illuminate\Support\Facades\Storage;

class LaporanExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithTitle, WithDrawings
{
    public function collection()
    {
        $laporans = Laporan::all('id', 'image', 'title', 'description', 'status', 'created_at', 'updated_at');

        foreach ($laporans as $laporan) {
            $laporan->created_at = $laporan->created_at->format('Y-m-d');
            $laporan->updated_at = $laporan->updated_at->format('Y-m-d');
        }

        return $laporans;
    }

    public function headings(): array
    {
        return [
            'ID', 'Image', 'Judul', 'Deskripsi', 'Status', 'Tanggal Dibuat', 'Tanggal Diubah'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 50,  
            'C' => 30,
            'D' => 50,
            'E' => 20,
            'F' => 20,
        ];
    }
    
    public function columnHeight(): int
    {
        return 60;
    }

    public function styles(Worksheet $sheet)
    {
        $laporans = Laporan::all();

        foreach ($laporans as $index => $laporan) {
            $row = $index + 2;
            $sheet->getRowDimension($row)->setRowHeight(90);
        }

        return [
            1    => ['font' => ['bold' => true]],
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
                    'startColor' => ['argb' => '4CAF50'],
                ],
            ],
            'B' => [
                'font' => [
                    'color' => ['argb' => 'FFFFFF'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Kriminalitas';
    }

    public function drawings()
    {
        $drawings = [];
        $laporans = Laporan::all();
    
        foreach ($laporans as $index => $laporan) {
            if ($laporan->image && Storage::exists('public/' . $laporan->image)) {
                $drawing = new Drawing();
                $drawing->setName('Image');
                $drawing->setDescription('Image from laporan');
                $drawing->setPath(Storage::path('public/' . $laporan->image));
                $drawing->setHeight(90);
    
                $row = $index + 2;
                $drawing->setCoordinates("B{$row}");
    
                $drawings[] = $drawing;
            }
        }
    
        return $drawings;
    }
}
