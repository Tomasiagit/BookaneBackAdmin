<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User	;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // This method should return a list of users
        $users = User::all();
        return response()->json([
            'status' => 200,
            'users' => $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $valiator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:7|confirmed',
        ]);

        if($valiator->fails()) {
            return response()->json([
                'status'=>422,
                'message' => $valiator->errors()
            ], 422);
        } else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'role_id'=>$request->role_id,
                'password' => Hash::make($request->password),
            ]);


            if($user){
                return response()->json([
                    'status' => 200,
                    'message' => 'Utilizador criado com sucesso!'
                ], 200);

            } else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Não foi possível criar o utilizador'
                ], 500
                );
            }
        }

    
            
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        if($user){
            return response()->json([
                'status' => 200,
                'message' => $user
            ], 200);

        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Utilizador não encontrado!'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        $validator = Validator::make($request->all(),
    [
        'name' => 'required|string|max:191',
        'email' => 'required|email|max:191',
        'role_id' => 'required|exists:roles,id', //'required|exists:roles,id',
        // 'password' => 'required|string|max:191',
       
    ]);

    if($validator->fails()){
        return response()->json([
            'status' => 422,
            'message' => $validator->errors()
        ], 422);

    }else{
        $user = User::find($id);
        if($user){
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => $request->input('role_id'),
                // 'password' => Hash::make($request->input('password'))
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Utilizador atualizado com sucesso'
            ], 200);

        } else{
            return response()->json([
                'status' => 404,
                'message' =>'Utilizador nao encontrado!'
            ], 404);
        }

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
        $user = User::find($id);
        if($user){
            $user->delete();
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Uttilizador não encontrado!'

            ], 404);
        }
    }
}
