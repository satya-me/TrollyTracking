<?php
namespace App\Exports;

use App\Models\ProductivityReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductivityReportExport implements FromCollection, WithHeadings
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return $this->reports;
    }

    public function headings(): array
    {
        return [
            'Trolly Name',
            'Department',
            'Supervisor',
            'Entry Time',
            'Exit Time',
            'Total Time',
            'Created At',
            'Updated At',
        ];
    }
}
