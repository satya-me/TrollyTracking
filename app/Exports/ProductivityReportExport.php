<?php
namespace App\Exports;

use App\Models\Productivity;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductivityReportExport implements FromQuery, WithHeadings, WithMapping
{
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;  
        $this->toDate = $toDate;
    }

    public function query()
    {
        return Productivity::query()
            ->whereBetween('entry_time', [$this->fromDate, $this->toDate]);
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
        ];
    }

    public function map($productivity): array
    {
        return [
            $productivity->trolly_name,
            $productivity->department,
            $productivity->supervisor,
            $productivity->entry_time,
            $productivity->exit_time,
            $productivity->total_time,
        ];
    }
}
