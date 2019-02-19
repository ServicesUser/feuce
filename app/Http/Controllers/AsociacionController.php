<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsociacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('aso');
    }
}
