<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Reporte;

/**
 * Controlador de las funciones para almacenar los reportes en pdf con sus temas y semanas
 */
class FileController extends Controller
{
    /**
     * Crea un nuevo reporte relacionado con su tema y materia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->has('materia') && $request->has('temas') && $request->has('semana') || $request->hasFile('file'));
        if (($request->filled(['materia', 'temas', 'semana']) || $request->hasFile('file')) && $request->filled(['materia', 'semana'])) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $uniqueName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        
                // Buscar el reporte existente
                $report = Reporte::where('materia', $request->materia)
                                ->where('semana', $request->semana)
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
                    $report->temas = $request->temas;
                    $report->semana = $request->semana;
                    $report->descripcion = $request->descripcion;
                    $report->save();
                }
        
                // Almacenar el archivo con el nombre único
                $path = $file->storeAs('public/pdfs', $uniqueName);
        
                return response()->json(['path' => $path], 200);
            } else {
                // Crear un nuevo reporte si no existe uno previo
                $report = new Reporte();
                $report->materia = $request->materia;
                $report->pdf_uid = '';
                $report->temas = $request->temas;
                $report->semana = $request->semana;
                $report->descripcion = $request->descripcion;
                $report->save();
                return response()->json(['message' => 'Report created'], 200);
            }
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Funcion para buscar todos los reportes semanales que estén relacionados a una materia con su `nrc`
     *
     * @param  int  $nrc
     * @return \Illuminate\Http\Response
     */
    public function show($nrc)
    {
        $reports =  Reporte::where('materia', $nrc)->get();
        return response()->json($reports,200);
    }
}
