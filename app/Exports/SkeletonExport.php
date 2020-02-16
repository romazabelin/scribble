<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SkeletonExport implements FromCollection, WithHeadings
{
    private $data;

    private $headData;

    use Exportable;

    public function __construct($data, $headData)
    {
        $this->data = $data;
        $this->headData = $headData;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headData;
    }

}