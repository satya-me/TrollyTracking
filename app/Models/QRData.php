<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRData extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor','grade_name', 'origin', 'batch_no', 'net_weight', 'gross_weight', 'lot_no', 'dispatch_status'
    ];
}
