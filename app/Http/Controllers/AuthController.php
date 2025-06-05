<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
// use App\Models\User;

class AuthController extends Controller
{
    //

    public function login(Request $request){

       $credentials = $request->only('email','password');

       try{

        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error' => 'Credenciais inválidas'], 401);

        }


       }catch(JWTException $e){
        return response()->json(['error' => 'Não foi possível criar to token'], 500);

       }
        $user = auth()->user();
       return response()->json(['token' => $token, 'user' => $user], 200);

    }


    public function logout(){

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Logout com sucesso']);


    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }


}
