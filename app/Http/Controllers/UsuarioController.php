<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Programacion;
use App\Http\Resources\ProgramacionResource;
use App\Http\Resources\ProgramacionCollection;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        $correo = $request->input('correo');
        $contrasena = $request->input('contrasena');

        $persona = Persona::where('email','=',$correo)->where('password','=',$contrasena)->first();

        if($persona){
            return response()->json($persona);
        }
        return response()->json(0, 203);
    }

    public function programacionestecnico(Request $request)
    {
        $id = $request->input('id');
        $programaciones = Programacion::where('id_tecnico', '=', $id)->get();
        return response()->json(new ProgramacionCollection($programaciones));
        //return response()->json($programaciones);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return 204;
    }
}
