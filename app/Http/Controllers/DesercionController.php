<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesercionController extends Controller
{
    public function periodo()
    {
        return view('desercion.periodo');
    }
    public function facultad()
    {
        return view('desercion.facultad');
    }
}
