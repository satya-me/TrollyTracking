<?php

namespace App\Exports;

use App\Models\QRData;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QRReportExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate . ' 00:00:00';
        $this->endDate = $endDate . ' 23:59:59';
    }

    public function query()
    {
        return QRData::query()->select([
            'dispatch_status',
            'grade_name',
            'origin',
            'batch_no',
            'net_weight',
            'gross_weight',
            'lot_no',
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at'),
        ])
          ->whereBetween('created_at', [$this->startDate, $this->endDate])
          ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Dispatch Status',
            'Grade Name',
            'Origin',
            'Batch No',
            'Net Weight',
            'Gross Weight',
            'Lot No',
            'Created Data',
        ];
    }
}
