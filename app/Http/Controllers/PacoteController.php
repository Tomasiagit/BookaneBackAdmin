<?php

namespace App\Http\Controllers;

use App\Models\Pacote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PacoteController extends Controller
{


    public function index(){
        $pacotes = Pacote::all();
        return response()->json([
            'status' => 200,
            'pacotes' => $pacotes
        ], 200);
    }

    public function store(Request $request){

          $validator = Validator::make($request->all(),[
            'duracao' => 'required|string|max:255',
            'valor' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' =>$validator->errors()
            ], 422);

        }else{
            $pacote = Pacote::create(
                [
                    'duracao' => $request->duracao,
                    'valor' => $request->valor
                ]
            );

                 if($pacote){
                return response()->json([
                    'status' => 200,
                    'message' => 'Pacote criado com sucesso!'
                ], 200);

            } else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Não foi possível criar o pacote'
                ], 500
                );
          }

        }
    } 
    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(),
        [
            'duracao' => 'required|string|max:255',
            'valor' => 'required|numeric',
        ]
    
    );

    if($validator->fails()){
        return response()->json([
            'status'=>422,
            'message' => $validator->errors()
        ],422);

    }else{
        $pacote = Pacote::find($id);
        if($pacote){
            $pacote->update([
                'duracao' => $request->input('duracao'),
                'valor' => $request->input('valor'),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Pacote atualizado com sucesso'

            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Utilizador nao encontrado!'
            ],404);
        }

    }

    }
   







    public function show($id){
        $pacote = Pacote::find($id);
        if($pacote){
            return response()->json([
                'status' => 200,
                'messge' => $pacote
            ], 200);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Pacote não encontrado'
            ], 400);
        }

    }


      public function destroy($id)
    {
        //
        $pacote = Pacote::find($id);
        if($pacote){
            $pacote->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Pacote Eliminado!'

            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Pacote não encontrado!'

            ], 404);
        }
    }
    
       
        }


