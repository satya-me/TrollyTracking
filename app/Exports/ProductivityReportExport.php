<?php

namespace App\Exports;

use App\Models\ProductivityReport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductivityReportExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $department;

    public function __construct($startDate, $endDate, $department)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->department = $department;
    }

    public function query()
    {
        return ProductivityReport::query()->select([
            'trolly_name',
            'department',
            'supervisor',
            'entry_time',
            'exit_time',
            'total_time',
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at'),
        ])
            ->when($this->department !== 'ALL', function ($query) {
                $query->where('department', $this->department);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc');
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
            'Created Date',
        ];
    }
}
