<?php
namespace App\Exports;

use App\Models\QRData;
use App\Models\Origin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QRReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $gradeName;
    protected $origin;
    protected $dispatchStatus;
    protected $origins;

    public function __construct($startDate, $endDate, $gradeName = null, $origin = null, $dispatchStatus = null)
    {
        $this->startDate = $startDate . ' 00:00:00';
        $this->endDate = $endDate . ' 23:59:59';
        $this->gradeName = $gradeName;
        $this->origin = $origin;
        $this->dispatchStatus = $dispatchStatus;
        $this->origins = Origin::pluck('origin')->toArray(); // Adjust the column name here
    }

    public function query()
    {
        $originCounts = array_map(function ($origin) {
            $alias = preg_replace('/[^a-zA-Z0-9_]/', '_', $origin);
            return DB::raw("SUM(CASE WHEN origin = '{$origin}' THEN 1 ELSE 0 END) as {$alias}_count");
        }, $this->origins);

        $query = QRData::query()
            ->select(array_merge(
                [
                    'grade_name',
                    DB::raw('COUNT(*) as total_record'),
                    DB::raw('SUM(CASE WHEN dispatch_status = "Dispatched" THEN 1 ELSE 0 END) as dispatched_count'),
                    DB::raw('SUM(CASE WHEN dispatch_status = "In_Stock" THEN 1 ELSE 0 END) as in_stock_count'),
                ],
                $originCounts
            ))
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('grade_name')
            ->orderBy('grade_name', 'asc');

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
        return array_merge(
            ['Grade Name', 'Total Record', 'In Hand'],
            array_map(function ($origin) {
                return preg_replace('/[^a-zA-Z0-9_]/', '_', $origin);
            }, $this->origins)
        );
    }

    public function map($row): array
    {
        $inHand = $row->total_record - $row->dispatched_count;

        $originCounts = array_map(function ($origin) use ($row) {
            $alias = preg_replace('/[^a-zA-Z0-9_]/', '_', $origin);
            return $row->{$alias . '_count'} ?? 0;
        }, $this->origins);

        return array_merge(
            [
                $row->grade_name,
                $row->total_record,
                $inHand,
            ],
            $originCounts
        );
    }
}
