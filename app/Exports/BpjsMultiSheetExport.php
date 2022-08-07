<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BpjsMultiSheetExport implements WithMultipleSheets
{
    private $year;

    public function __construct(string $year)
    {
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new Pasien_BPJSExport($this->year, $month);
        }

        return $sheets;
    }
}
