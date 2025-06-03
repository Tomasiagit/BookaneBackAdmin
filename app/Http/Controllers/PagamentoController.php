<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagamentoController extends Controller
{
    //
    public function index(){
        $pagamento = Pagamento::all();

        return response()->json([
            'status' => 200,
            'message' => $pagamento,
        ], 200);


    }
    public function show($pagamento_id){
        $pagamento = Pagamento::find($pagamento_id);

            if($pagamento){
                return response()->json([
                    'status'=> 200,
                    'message'=>$pagamento

        	         ],200);

            }else{
                return response()->json([
                    'status'=>404,
                    'message' => 'Pagamento não encontrado'
                ]);
            }
    }

   
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'pacote_id' => 'required|exists:pacotes,id',
            'classe_id' => 'required|exists:classes,id',
            'estado' => 'required|string|max:30',
            'data_inicio'=> 'required|string|max:50',
            'data_fim' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' =>$validator->errors(),

            ], 422);

        } else{
            $pagamento = Pagamento::create([
                'user_id' => $request->user_id,
                'pacote_id' => $request->pacote_id,
                'classe_id' => $request->classe_id,
                'estado' => $request->estado,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim
            ]);
            if($pagamento){
                return response()->json([
                    'status' => 200,
                    'message' => 'Pagamento efectuado com sucesso!'

                ], 200);

            }else{
                return response()->json([
                'status' => 500,
                'message' => 'Nao foi possivel efectuar o pagamento!'
                ],500);
                
            }

        }



    }
    public function update(Request $request, $pagamento_id){
          $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'pacote_id' => 'required|exists:pacotes,id',
            'classe_id' => 'required|exists:classes,id',
            'estado' => 'required|string|max:30',
            'data_inicio'=> 'required|string|max:50',
            'data_fim' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' =>$validator->errors(),

            ], 422);

        } else{
            $pagamento = Pagamento::find($pagamento_id);
            if($pagamento){
                  $pagamento = Pagamento::update([
                'user_id' => $request->input('user_id'),
                'pacote_id' => $request->input('pacote_id'),
                'classe_id' => $request->input('classe_id'),
                'estado' => $request->input('estado'),
                'data_inicio' => $request->input('data_inicio'),
                'data_fim' => $request->input('data_fim')
            ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Pagamento atualizado com sucesso!'

                ], 200);

            }else{
                return response()->json([
                'status' => 500,
                'message' => 'Nao foi possivel actualizar o pagamento!'
                ],500);
                
            }

        }


    }
    public function destroy($pagamento_id){
        $pagamento = Pagamento::find($pagamento_id);

        if($pagamento){
            $pagamento->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Pagamento apagado com sucesso'
            ], 200);

        }else{
             return response()->json([
              'status'=> 404,
              'message'=> 'pagamento não encontrado'  
            ],404);

        }

    }
}
