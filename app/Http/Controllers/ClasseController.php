<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;

class ClasseController extends Controller
{
    //

    public function index(){
        $classes = Classe::all();

        return response()->json([
            'status' => 200,
            'classes' => $classes

        ], 200);
    }
}
