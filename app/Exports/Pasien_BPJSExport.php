<?php

namespace App\Exports;

use App\Models\Pasien_BPJS;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
// use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Pasien_BPJSExport implements
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents,
    FromQuery,
    // WithDrawings,
    WithCustomStartCell,
    WithTitle
{
    use Exportable;

    // private $year;

    // private $month;

    public function __construct(string $year, string $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function query()
    {
        return  Pasien_BPJS::query()
            ->whereYear('Tanggal', $this->year)
            ->whereMonth('Tanggal', $this->month);
    }

    public function map($bpjs): array
    {
          return [
                $bpjs->No_BPJS,
                $bpjs->No_Rekam_Medis,
                $bpjs->Nama,
                $bpjs->Umur,
                $bpjs->Jenis_Kelamin,
                $bpjs->Alamat,
                $bpjs->No_Telepon,
                $bpjs->Pemeriksaan,
                $bpjs->Diagnosa,
                $bpjs->Terapi,
                date('d-m-Y', strtotime($bpjs->Tanggal)),
            ];
    }

    public function headings(): array
    {
        return [
            'No_BPJS',
            'No_Rekam_Medis',
            'Nama',
            'Umur',
            'Jenis_Kelamin',
            'Alamat',
            'No_Telepon',
            'Pemeriksaan',
            'Diagnosa',
            'Terapi',
            'Tanggal',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A8:D8')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/laravel-logo.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B2');

    //     return $drawing;
    // }

    public function startCell(): string
    {
        return 'A2';
    }

    public function title(): string
    {
        return DateTime::createFromFormat('!m', $this->month)->format('F');
    }
}