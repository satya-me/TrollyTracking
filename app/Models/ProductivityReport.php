<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductivityReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'trollyName', 'department', 'supervisor',
    ];
}
