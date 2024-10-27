<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpsController extends Controller
{
    public function periodo()
    {
        return view('pps.periodo');
    }
    public function facultad()
    {
        return view('pps.facultad');
    }
}
