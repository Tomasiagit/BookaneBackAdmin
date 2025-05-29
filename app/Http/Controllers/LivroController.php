<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivroController extends Controller
{
    public function index(){
        $livro = Livro::all();
        return response()->json([
            'status' => 200,
            'users' => $livro 
        ], 200);

    }
     
      public function store(Request $request)
    {
        //
        $valiator = Validator::make($request->all(), [
        'disciplina' => 'required|string|max:50',
        'classe' => 'required|string|max:50',
        'classe_id'=> 'required|exists:classes,id',
        'arquivo' => 'required|string|max:9999',   
        ]);

        if($valiator->fails()) {
            return response()->json([
                'status'=>422,
                'message' => $valiator->errors()
            ], 422);
        } else{
            $user = Livro::create([
                'disciplina' => $request->input('disciplina'),
                'classe' => $request->input('classe'),
                'classe_id'=>$request->input('classe_id'),
                'arquivo' => $request->input('arquivo'),
            ]);


            if($user){
                return response()->json([
                    'status' => 200,
                    'message' => 'LIvro criado com sucesso!'
                ], 200);

            } else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Não foi possível publicar o livro!'
                ], 500
                );
            }
        }
    }
    //
     public function update(Request $request, int $id)
    {
        //
        $validator = Validator::make($request->all(),
    [
        'disciplina' => 'required|string|max:50',
        'classe' => 'required|string|max:50',
        'classe_id'=> 'required|exists:classes,id',
        'arquivo' => 'required|string|max:9999',   
    ]);

    if($validator->fails()){
        return response()->json([
            'status' => 422,
            'message' => $validator->errors()
        ], 422);

    }else{
        $user = Livro::find($id);
        if($user){
            $user->update([
                'disciplina' => $request->input('disciplina'),
                'classe' => $request->input('classe'),
                'classe_id'=>$request->input('classe_id'),
                'arquivo' => $request->input('arquivo'),
               
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Livro atualizado com sucesso'
            ], 200);

        } else{
            return response()->json([
                'status' => 404,
                'message' =>'Livro nao encontrado!'
            ], 404);
        }

    }
        
    }
     public function show($id)
    {
        //
        $livro = Livro::find($id);
        if($livro){
            return response()->json([
                'status' => 200,
                'message' => $livro
            ], 200);

        } else{
            return response()->json([
                'status' => 404,
                'message' => 'LIvro não encontrado!'
            ], 404);
        }
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
        $livro = Livro::find($id);
        if($livro){
            $livro->delete();
             return response()->json([
                'status' => 200,
                'message' => 'Registo Apagado com sucesso!'

             ]);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Livro não encontrado!'

            ], 404);
        }
    }
}
