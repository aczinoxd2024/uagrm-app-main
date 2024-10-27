<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpacController extends Controller
{
    public function periodo()
    {
        return view('ppac.periodo');
    }
    public function facultad()
    {
        return view('ppac.facultad');
    }
    public function sin0facultad()
    {
        return view('ppac.sin0facultad');
    }
    public function sin0periodo()
    {
        return view('ppac.sin0periodo');
    }
}
