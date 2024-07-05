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
    protected $gradeName;
    protected $origin;
    protected $dispatchStatus;

    public function __construct($startDate, $endDate, $gradeName = null, $origin = null, $dispatchStatus=null)
    {
        $this->startDate = $startDate . ' 00:00:00';
        $this->endDate = $endDate . ' 23:59:59';
        $this->gradeName = $gradeName;
        $this->origin = $origin;
        $this->dispatchStatus = $dispatchStatus;
    }

    public function query()
    {
        $query = QRData::query()
            ->select([
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

        if ($this->gradeName) {
            $query->where('grade_name', $this->gradeName);
        }
        if ($this->origin) {
            $query->where('origin', $this->origin);
        }
        if ($this->dispatchStatus) {
            $query->where('dispatch_status', $this->dispatchStatus);
        }

        return $query;
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
            'Created Date',
        ];
    }
}
