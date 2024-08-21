<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $inscripciones = Inscripcion::with('materia.programa:clave,nombre', 'materia.profesor:id,nombre,apellido')->where('usuario', $id)->select(['id', 'materia'])->get();

        return response()->json($inscripciones, 200);
    }

    public function horarioProfesor($id)
    {
        $inscripciones = Materia::with('programa:clave,nombre', 'profesor:id,nombre,apellido')->where('profesor', $id)->get();

        return response()->json($inscripciones,200);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
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
