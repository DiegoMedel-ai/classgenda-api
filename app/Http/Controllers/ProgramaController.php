<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programas = Programa::all();

        return response()->json($programas, 200);
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
            'clave' => 'nullable|integer',
            'nombre' => 'nullable|string',
            'tipo' => 'nullable|string',
            'creditos' => 'nullable|integer',
            'requisito' => 'nullable|integer',
            'simultaneo' => 'nullable|integer',
            'horas_practica' => 'nullable|integer',
            'horas_curso' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'perfil_egreso' => 'nullable|string'
        ]);

        $programa = Programa::create($validatedData);
        return response()->json($programa, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $programa = Programa::findOrFail($id);

        return response()->json($programa, 200);
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
            'clave' => 'nullable|integer',
            'nombre' => 'nullable|string',
            'tipo' => 'nullable|string',
            'creditos' => 'nullable|integer',
            'requisito' => 'nullable|integer',
            'simultaneo' => 'nullable|integer',
            'horas_practica' => 'nullable|integer',
            'horas_curso' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'perfil_egreso' => 'nullable|string'
        ]);

        $programa = Programa::findOrFail($validatedData['clave'])->update($validatedData);
        return response()->json($programa, 200);
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
            Programa::where('clave', $id)->delete();
            return response()->json(['message' => 'programa deleted'],200);
        }else {
            return response()->json(['message'=> 'id required'],404);
        }
    }
}
