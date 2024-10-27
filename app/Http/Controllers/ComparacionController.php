<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComparacionController extends Controller
{
    public function periodo()
    {
        return view('comparacion.periodo');
    }
    public function facultad()
    {
        return view('comparacion.facultad');
    }
}
