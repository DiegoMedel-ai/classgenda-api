<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Http\Request;

/**
 * Controlador de las funciones que corresponden a las inscripciones
 */
class InscripcionController extends Controller
{
    /**
     * Muestra la lista de las inscripciones con el profesor y el programa al que pertenece
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $inscripciones = Inscripcion::with('materia.programa:clave,nombre', 'materia.profesor:id,nombre,apellido')->where('usuario', $id)->select(['id', 'materia'])->get();

        return response()->json($inscripciones, 200);
    }

    /**
     * Muestra la lista del horario del profesor segun las materias en las que esté matriculado
     *
     * @return \Illuminate\Http\Response
     */
    public function horarioProfesor($id)
    {
        $inscripciones = Materia::with('programa:clave,nombre', 'profesor:id,nombre,apellido')->where('profesor', $id)->get();

        return response()->json($inscripciones,200);
    }

    /**
     * Crea una nueva inscripcion con el id del usuario y la materia a matricular
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario'=> 'integer|required',
            'materia'=> 'integer|required'
        ]);

        $inscripcion = Inscripcion::create($validatedData);
        return response()->json($inscripcion,200);
    }

    /**
     * Muestra la lista de usuarios que están inscritos en una materia
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUsers($id)
    {
        $users = Inscripcion::where('materia', $id)->with('usuario:id,nombre,apellido,foto_url')->select('usuario')->get();
        return response()->json($users,200);
    }

    /**
     * Borra el registro de la inscripcion del usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {
            Inscripcion::where('id', $id)->delete();
            return response()->json(['message' => 'inscripcion deleted'],200);
        }else {
            return response()->json(['message'=> 'id required'],404);
        }

    }
}
