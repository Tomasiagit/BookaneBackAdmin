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
            'livros' => $livro 
        ], 200);

    }
     
      public function store(Request $request)
    {
        //
        $valiator = Validator::make($request->all(), [
        'disciplina' => 'required|string|max:50',
        'classe' => 'required|string|max:50',
        'classe_id'=> 'required|exists:classes,id',
        'arquivo' => 'required|file|mimes:pdf,doc,docx,epub|max:10240',
        'capa' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048' 
        ]);
        // Save the image to storage/app/public/fotos
        $path = $request->file('capa')->store('capa', 'public');
        $url = asset('storage/' . $path);

        if($valiator->fails()) {
            return response()->json([
                'status'=>422,
                'message' => $valiator->errors()
            ], 422);
        } else{
            $livro = Livro::create([
                'disciplina' =>$request->disciplina,
                'classe' => $request->classe,
                'classe_id'=>$request->classe_id,
                'arquivo' => $request->arquivo,
                'capa' => $request->capa
            ]);

            


            if($livro){
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
        'arquivo' => 'required|file|mimes:pdf,doc,docx,epub|max:10240',
        'capa' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        
    ]);
    $path = $request->file('capas')->store('capa', 'public');
    $url = asset('storage/' . $path);

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
                'capa' => $request->input('capa'),
               
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
    public function livrosPorClasse($classe_id){
        $livros = Livro::where('classe_id',$classe_id)->get();

        if($livros){
            return response()->json($livros);

        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Livros não encontrados'

            ],404);
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
