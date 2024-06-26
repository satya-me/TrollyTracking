<?php
namespace App\Exports;

use App\Models\ProductivityReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductivityReportExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Trolly Name',
            'Department',
            'Supervisor',
            'Entry Time',
            'Exit Time',
            'Total Time',
            'Created At',
            'Updated At'
        ];
    }
}
