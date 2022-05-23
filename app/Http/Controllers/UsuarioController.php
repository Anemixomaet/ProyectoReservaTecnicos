<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Persona;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        $correo = $request->input('correo');
        $contrasena = $request->input('contrasena');

        $persona = Persona::where('email','=',$correo)->where('password','=',$contrasena)->first();

        if($persona){
            return $persona->id;
        }
        return response()->json(0, 203);
    }

    public function store(Request $request)
    {
        return Article::create($request->all());
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
