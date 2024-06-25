<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRTempData extends Model
{
    use HasFactory;

    protected $table = 'q_r_temp_data'; // Specify the table name if different from model name
    protected $fillable = [
        'grade_name', 'origin', 'batch_no', 'net_weight', 'gross_weight', 'lot_no'
    ];
}
