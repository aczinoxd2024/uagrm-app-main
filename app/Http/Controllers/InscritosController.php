<?php

namespace App\Http\Controllers;

use App\Models\DatosAcademicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscritosController extends Controller
{
    public function carreraFacultad(Request $request)
    {
        // Valores por defecto
        $facultad = $request->input('fac', '');  // Facultad por defecto: todas las facultades
        $periodo = $request->input('periodo', '2020-1');  // Periodo por defecto: 2020-1
        $modalidad = $request->input('modalidad', ''); // Modalidad por defecto: todas las modalidades

        // Realizar la consulta con los datos recibidos
        $query = DatosAcademicos::select('nombre_carrera', DB::raw('SUM(ins) as total_inscritos'))
            ->where('periodo', $periodo)  // Siempre filtrar por periodo
            ->groupBy('nombre_carrera')
            ->orderBy('total_inscritos', 'desc');

        // Si el valor de facultad no es vacío, aplicar el filtro
        if (!empty($facultad)) {
            $query->where('fac', $facultad);
        }

        // Si el valor de modalidad no es vacío, aplicar el filtro
        if (!empty($modalidad)) {
            $query->where('modalidad', $modalidad);
        }

        // Ejecutar la consulta
        $inscritos = $query->get();

        // Obtener las carreras y totales
        $carreras = $inscritos->pluck('nombre_carrera')->toArray(); // Obtener las carreras
        $totales = $inscritos->pluck('total_inscritos')->toArray(); // Obtener el total de inscritos

        // Si es una solicitud AJAX, retornar solo los datos en formato JSON
        if ($request->ajax()) {
            return response()->json([
                'carreras' => $carreras,
                'totales' => $totales
            ]);
        }

        // Si no es AJAX, retornar la vista completa
        return view('inscritos.carrera-facultad', compact('inscritos', 'carreras', 'totales'));
    }


    public function carrera(Request $request)
    {
        // Obtener los datos de la solicitud con valores predeterminados
        $facultad = $request->input('fac');
        $periodo = $request->input('periodo', '2020-1');
        $modalidad = $request->input('modalidad');
    
        // Construir la consulta con condiciones opcionales
        $query = DatosAcademicos::select('nombre_carrera', 'modalidad', DB::raw('SUM(ins) as total_inscritos'))
            ->where('periodo', $periodo);
    
        if ($facultad) {
            $query->where('fac', $facultad);
        }
    
        if ($modalidad) {
            $query->where('modalidad', $modalidad);
        }
    
        $inscritos = $query->groupBy('nombre_carrera', 'modalidad')
                           ->orderByDesc('total_inscritos')
                           ->get();
    
        // Extraer datos para la gráfica y sumar el total general
        $carreras = $inscritos->pluck('nombre_carrera')->toArray();
        $totales = $inscritos->pluck('total_inscritos')->toArray();
        $sumatot = $inscritos->sum('total_inscritos');
    
        // Si es una solicitud AJAX, devolver JSON; si no, cargar la vista inicial
        if ($request->ajax()) {
            return response()->json([
                'carreras' => $carreras,
                'totales' => $totales,
                'sumatot' => $sumatot
            ]);
        }
   /*dd($totales);*/
        return view('inscritos.carrera', compact('inscritos', 'carreras', 'totales', 'sumatot'));
    }
    
    





    public function facultad()
    {
        return view('inscritos.facultad');
    }



    public function localidad(Request $request)
    {
        // Obtener el periodo de la solicitud o usar 2020-1 como valor por defecto
        $periodo = $request->input('periodo', '2020-1');
        // Obtener la facultad de la solicitud, si está vacío se buscarán todas las facultades
        $facultad = $request->input('fac', '');

        // Crear la consulta base para el periodo dado
        $query = DatosAcademicos::select('localidad', DB::raw('SUM(ins) as total_inscritos'))
            ->where('periodo', $periodo)
            ->groupBy('localidad')
            ->orderBy('total_inscritos', 'desc');

        // Si la facultad no está vacía, agregar el filtro
        if (!empty($facultad)) {
            $query->where('fac', $facultad);
        }

        // Ejecutar la consulta
        $inscritos = $query->get();

        // Obtener las localidades y totales de inscritos
        $localidades = $inscritos->pluck('localidad')->toArray();
        $totales = $inscritos->pluck('total_inscritos')->toArray();

        // Sumar el total de inscritos en todas las localidades
        $total = $inscritos->sum('total_inscritos');

        // Si es una solicitud AJAX, retornar solo los datos en formato JSON
        if ($request->ajax()) {
            return response()->json([
                'localidades' => $localidades,
                'totales' => $totales,
            ]);
        }

        // Si no es una solicitud AJAX, retornar la vista completa
        return view('inscritos.localidad', compact('inscritos', 'localidades', 'totales', 'total'));
    }



    public function modalidad()
    {
        return view('inscritos.modalidad');
    }

    public function nuevoCarrera()
    {
        return view('inscritos.nuevo-carrera');
    }
}
