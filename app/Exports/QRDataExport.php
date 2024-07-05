<?php
namespace App\Exports;

use App\Models\QRData;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB; // Import the DB facade

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
            ->select('grade_name', DB::raw('COUNT(*) as quantity'), 'origin')
            ->where('grade_name', $this->gradeName)
            ->where('dispatch_status', $this->dispatchStatus)
            ->groupBy('grade_name', 'origin')
            ->orderBy('grade_name');
    }

    public function headings(): array
    {
        return [
            'Grade Name',
            'Quantity',
            'Origin',
        ];
    }
}
