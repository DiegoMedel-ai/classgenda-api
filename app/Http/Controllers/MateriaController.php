<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materia = Materia::with('profesor:id,nombre', 'programa:clave,nombre')->get();
        return response()->json($materia, 200);
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
            'nrc' => 'nullable|integer',
            'programa' => 'nullable|integer',
            'dias_clase' => 'nullable|string',
            'hora_inicio' => 'nullable|string',
            'hora_final' => 'nullable|string',
            'edificio' => 'nullable|string',
            'aula' => 'nullable|integer',
            'profesor' => 'nullable|integer'
        ]);

        $materia = Materia::create($validatedData);
        return response()->json($materia, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
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

        $materia = Materia::findOrFail($validatedData['nrc'])->update($validatedData);
        return response()->json($materia, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
