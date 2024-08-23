<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }

    public function profesores()
    {
        return response()->json(Usuario::where("rol", 3)->orWhere("rol", 4)->get()->makeHidden('constraseña'), 200);
    }

    public function alumnosInfo()
    {
        return response()->json(Usuario::where("rol", 2)->get()->makeHidden('constraseña'), 200);
    }

    public function lastIndex()
    {
        $lastUser = Usuario::latest('id')->first();

        if ($lastUser) {
            $nextId = $lastUser->id + 1;
        } else {
            $nextId = 1;
        }

        return response()->json(['id' => $nextId]);
    } 

    public function login(Request $request) {
        $user = Usuario::with('tipos_usuario')->where('correo', $request->correo)->first();
        if ($user) {
            if ($user->situacion != 1) {
                return response()->json(["message" => "User doesnt exists"], 402);
            } else if (hash('sha512', $request->password ) != $user->contraseña) {
                return response()->json(["message" => "Passowrd not match"], 401);
            }else {
                return response()->json(["user" => ["id" => $user->id, "rol" => $user->tipos_usuario->rol]], 200);
            }
        } else {
            return response()->json(["message" => "User doesnt exists"], 402);
        }
    }

    public function show(Request $request){
        $usuario = Usuario::where("id", $request->id)->first();
        if ($usuario) {
            return response()->json(["nombre"=> $usuario->nombre." ".$usuario->apellido, "foto_url" => $usuario->foto_url]);
        }else {
            return response()->json(["message"=> "User not found"], 400);
        }
    }

    public function getAllInfo($id){
        $usuario = Usuario::where("id", $id)->first()->makeHidden("contraseña");
        return response()->json($usuario, 200);
    }

    public function storeImg(Request $request)
    {
        if ($request->hasFile('file') && $request->has('userId')) {
            $file = $request->file('file');
            $uniqueName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
    
            $user = Usuario::where('id', $request->userId)->first();
    
            if (!is_null($user->foto_url)) {
                $filePath = 'public/img/' . $user->foto_url;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            $user->update(['foto_url' => $uniqueName]);
            $path = $file->storeAs('public/img', $uniqueName);
    
            return response()->json(['path' => $path], 200);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new Usuario;
        $user->rol = $request->rol ?? 2;
        $user->nombre = $request->nombre ?? "";
        $user->apellido = $request->apellido ?? "";
        $user->correo = $request->correo ?? "";
        $user->carrera = $request->carrera ?? "";
        $user->centro = $request->centro ?? "";
        $user->situacion = 2;
        $user->telefono = $request->telefono ?? "";
        $user->foto_url = $request->foto_url ?? "";
        $user->contraseña = $request->password ? hash('sha512', $request->password) : "";

        $user->save();

        return response()->json(["message" => "User stored."], 200);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'integer|required',
            'rol' => 'integer|required',
            'correo' => 'string|required',
            'centro' => 'string|required',
            'carrera' => 'string|required',
            'nombre' => 'string|required',
            'apellido' => 'string|required',
            'situacion' => 'integer|required',
            'foto_url' => 'string|nullable',
            'telefono' => 'string|nullable',
        ]);

        $usuario = Usuario::findOrFail($validatedData['id'])->update($validatedData);
        return response()->json($usuario, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Usuario::find($id);

        if ($user) {
            $user->delete();
            return response()->json(["message" => "User deleted."], 200);
        } else {
            return response()->json(["message" => "User not found."], 404);
        }
    }
}
