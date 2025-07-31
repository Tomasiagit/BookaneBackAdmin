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
    $validator = Validator::make($request->all(), [
        'disciplina' => 'required|string|max:50',
        'classe' => 'required|string|max:50',
        'classe_id'=> 'required|exists:classes,id',
        'arquivo' => 'required|file|mimes:pdf,doc,docx,epub',
        'capa' => 'required|image|mimes:jpg,jpeg,png,gif,webp' 
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'message' => $validator->errors()
        ], 422);
    }

    
    $arquivoPath = null;
    $capaPath = null;

    if ($request->hasFile('arquivo')) {
        $arquivoPath = $request->file('arquivo')->store('arquivos', 'public');
    }

    if ($request->hasFile('capa')) {
        $capaPath = $request->file('capa')->store('capas', 'public');
    }

    $livro = Livro::create([
        'disciplina' => $request->disciplina,
        'classe' => $request->classe,
        'classe_id' => $request->classe_id,
        'arquivo' => $arquivoPath,
        'capa' => $capaPath,
    ]);

    if ($livro) {
        return response()->json([
            'status' => 200,
            'message' => 'Livro criado com sucesso!',
            'arquivo_url' => $arquivoPath,
            'capa_url' => $capaPath,
        ], 200);
    } else {
        return response()->json([
            'status' => 500,
            'message' => 'Não foi possível publicar o livro.'
        ], 500);
    }
}

     
    //   public function store(Request $request)
    // {
    //     //
    //     $arquivoPath = null;
    //     $capaPath = null; 

    //     $valiator = Validator::make($request->all(), [
    //     'disciplina' => 'required|string|max:50',
    //     'classe' => 'required|string|max:50',
    //     'classe_id'=> 'required|exists:classes,id',
    //     'arquivo' => 'required|file|mimes:pdf,doc,docx,epub',
    //     'capa' => 'required|image|mimes:jpg,jpeg,png,gif,webp' 
    //     ]);
       
    //     if($request->hasFile('arquivo')){
    //         $arquivoPath = $request->file('arquivo')->store('arquivos', 'public');
    //     }
    //     if($request->hasFile('capa')){
    //         $capaPath = $request->file('capa')->store('capas', 'public');
    //     }
        
        
    //     // $urlCapa = asset('storage/' . $capaPath);
    //     // $urlArquivo = asset('storage/' . $arquivoPath);

    //     if($valiator->fails()) {
    //         return response()->json([
    //             'status'=>422,
    //             'message' => $valiator->errors()
    //         ], 422);
    //     } else{
    //         $livro = Livro::create([
    //             'disciplina' =>$request->disciplina,
    //             'classe' => $request->classe,
    //             'classe_id'=>$request->classe_id,
    //             'arquivo' =>   $arquivoPath,
    //             'capa' =>  $capaPath
               
    //         ]);

    //         if($livro){
    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'LIvro criado com sucesso!',
    //                 'arquivo_url' => $arquivoPath,
    //                 'capa_url' => $capaPath,
                    
    //             ], 200);

    //         } else{
    //             return response()->json([
    //                 'status' => 500,
    //                 'message' => 'Não foi possível publicar o livro!'
    //             ], 500
    //             );
    //         }
    //     }
    // }
    //
     public function update(Request $request, int $id)
    {

        //
        $arquivoPath = null;
        $capaPath = null;

        $validator = Validator::make($request->all(),
    [
        'disciplina' => 'required|string|max:50',
        'classe' => 'required|string|max:50',
        'classe_id'=> 'required|exists:classes,id', 
        'arquivo' => 'required|file|mimes:pdf,doc,docx,epub|max:10240',
        'capa' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        
    ]);
        if($request->hasFile('arquivo')){
            $arquivoPath = $request->file('arquivo')->store('arquivos', 'public');
        }
        if($request->hasFile('capa')){
            $capaPath = $request->file('capa')->store('capas', 'public');
        }
        
        
        $urlCapa = asset('storage/' . $capaPath);
        $urlArquivo = asset('storage/' . $arquivoPath);

    if($validator->fails()){
        return response()->json([
            'status' => 422,
            'message' => $validator->errors()
        ], 422);

    }else{
        $livro = Livro::find($id);
        if($livro){
            $livro->update([
                'disciplina' => $request->input('disciplina'),
                'classe' => $request->input('classe'),
                'classe_id'=>$request->input('classe_id'),
                'arquivo' => $request->input($urlArquivo),
                'capa' => $request->input($urlCapa),
               
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
