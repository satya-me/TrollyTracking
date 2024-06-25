<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrintController extends Controller
{
    public function printText(Request $request)
    {
        return $request;
    }
}
