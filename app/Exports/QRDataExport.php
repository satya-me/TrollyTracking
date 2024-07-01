<?php
namespace App\Exports;

use App\Models\QRData;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class QRDataExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $gradeName;
    protected $dispatchStatus;

    public function __construct($gradeName, $dispatchStatus)
    {
        $this->gradeName = $gradeName;
        $this->dispatchStatus = $dispatchStatus;
    }

    public function query()
    {
        return QRData::query()
            ->where('grade_name', $this->gradeName)
            ->where('dispatch_status', $this->dispatchStatus);
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
