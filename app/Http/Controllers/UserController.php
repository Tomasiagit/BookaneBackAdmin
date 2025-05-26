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
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:7|confirmed',
            ]
        );

        $valiator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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

        // $validated['password'] = bcrypt($validated['password']);
        // $user = User::create($validated);
        // return response()->json($user, 201);
            
    
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $validated = $request->validate(
            [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]
        );
        if(isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        $user->update($validated);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json(null, 204);
    }
}
