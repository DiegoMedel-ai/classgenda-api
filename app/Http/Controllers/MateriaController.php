<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

/**
 * Controlador de las funciones para modificar, añadir y borrar las materias 
 */
class MateriaController extends Controller
{
    /**
     * Muestra una lista de las materias con la información del profesor y programa
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materia = Materia::with('profesor:id,nombre,apellido', 'programa:clave,nombre')->get();
        return response()->json($materia, 200);
    }

    /**
     * Almacena una nueva materia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida los datos enviados en la solicitud
        $validatedData = $request->validate([
            'nrc' => 'nullable|integer',
            'programa' => 'nullable|integer',
            'dias_clase' => 'nullable|string',
            'hora_inicio' => 'nullable|string',
            'hora_final' => 'nullable|string',
            'edificio' => 'nullable|string',
            'aula' => 'nullable|integer',
            'profesor' => 'nullable|integer'
        ]);

        // Crea una nueva materia con los datos validados
        $materia = Materia::create($validatedData);
        return response()->json($materia, 200);
    }

    /**
     * Muestra una materia específica con la información del profesor y programa
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Busca la materia por su ID e incluye el profesor y programa asociados
        $materia = Materia::with('profesor:id,nombre,apellido,codigo', 'programa:clave,nombre')->findOrFail($id);
        return response()->json($materia, 200);
    }

    /**
     * Actualiza una materia existente
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Valida los datos enviados en la solicitud
        $validatedData = $request->validate([
            'nrc' => 'nullable|integer',
            'programa' => 'nullable|integer',
            'dias_clase' => 'nullable|string',
            'hora_inicio' => 'nullable|string',
            'hora_final' => 'nullable|string',
            'edificio' => 'nullable|string',
            'aula' => 'nullable|integer',
            'profesor' => 'nullable|integer',
            'temas' => 'nullable|string'
        ]);

        // Encuentra la materia por su NRC y la actualiza con los datos validados
        $materia = Materia::findOrFail($validatedData['nrc'])->update($validatedData);
        return response()->json($materia, 200);
    }

    /**
     * Actualiza el profesor de una materia específica
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfesor(Request $request)
    {
        // Valida los datos para el NRC y profesor
        $validatedData = $request->validate([
            'nrc' => 'required|integer',
            'profesor' => 'nullable|integer'
        ]);

        // Actualiza el profesor de la materia según el NRC
        $materia = Materia::findOrFail($validatedData['nrc'])->update($validatedData);
        return response()->json($materia, 200);
    }

    /**
     * Muestra las materias que pertenecen a un programa específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMateriasPrograma($id)
    {
        $materias = Materia::with('profesor:id,nombre,apellido', 'programa:clave,nombre')->where('programa', $id)->get();
        return response()->json($materias, 200);
    }

    /**
     * Muestra los profesores asociados a un programa específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProfesoresMateria($id)
    {
        $profesores = Materia::where('programa', $id)->with('profesor:id,nombre,apellido,foto_url')->select('profesor')->distinct()->get();
        return response()->json($profesores, 200);
    }

    /**
     * Elimina una materia específica de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {
            Materia::where('nrc', $id)->delete();
            return response()->json(['message' => 'Materia eliminada'], 200);
        } else {
            return response()->json(['message' => 'ID requerido'], 404);
        }
    }
}
