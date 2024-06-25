<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductivityReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'trolly_name', 'department', 'supervisor',
        'entry_time', 'exit_time', 'total_time',
    ];

}
