<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EgresadosController extends Controller
{
    public function periodo()
    {
        return view('egresados.periodo');
    }
    public function facultad()
    {
        return view('egresados.facultad');
    }
}
