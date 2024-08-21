<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Reporte;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file') && $request->has('materia') && $request->has('tema')) {
            $file = $request->file('file');
            $uniqueName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
    
            // Buscar el reporte existente
            $report = Reporte::where('materia', $request->materia)
                             ->where('temas', $request->tema)
                             ->first();
    
            if (isset($report)) {
                // Verificar si el archivo PDF anterior existe
                $filePath = 'public/pdfs/' . $report->pdf_uid;
                if (Storage::exists($filePath)) {
                    // Eliminar el archivo PDF anterior
                    Storage::delete($filePath);
                }
    
                // Actualizar el pdf_uid con el nuevo nombre único
                $report->update(['pdf_uid' => $uniqueName]);
            } else {
                // Crear un nuevo reporte si no existe uno previo
                $report = new Reporte();
                $report->materia = $request->materia;
                $report->pdf_uid = $uniqueName;
                $report->temas = $request->tema;
                $report->save();
            }
    
            // Almacenar el archivo con el nombre único
            $path = $file->storeAs('public/pdfs', $uniqueName);
    
            return response()->json(['path' => $path], 200);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $nrc
     * @return \Illuminate\Http\Response
     */
    public function show($nrc)
    {
        $reports =  Reporte::where('materia', $nrc)->get();
        return response()->json($reports,200);
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
        //
    }
}
