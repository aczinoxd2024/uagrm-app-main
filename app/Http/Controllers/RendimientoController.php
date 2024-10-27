<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RendimientoController extends Controller
{
    public function periodo()
    {
        return view('rendimiento.periodo');
    }
    public function facultad()
    {
        return view('rendimiento.facultad');
    }
}
