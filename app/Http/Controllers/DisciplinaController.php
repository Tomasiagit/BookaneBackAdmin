<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    //

    public function index(){
        $disciplinas = Disciplina::all();
        return response()->json([
            'status' => 200,
            'disciplinas' => $disciplinas
        ], 200);

    }
}
