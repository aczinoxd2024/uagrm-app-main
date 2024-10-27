<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TituladosController extends Controller
{
    public function periodo()
    {
        return view('titulados.periodo');
    }
    public function facultad()
    {
        return view('titulados.facultad');
    }


}
