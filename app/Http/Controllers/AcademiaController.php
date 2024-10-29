<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Academia;
use Illuminate\Http\Request;

/**
 * Controlador de las funciones que corresponden a las inscripciones
 */
class AcademiaController extends Controller
{
    /**
     * Muestra todas las academias existentes
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAcademias()
    {
        $academias = Academia::all();
        return response()->json($academias, 200);
    }

    /**
     * Muestra todos los departamentos existentes
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDepartamentos()
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos, 200);
    }
}
