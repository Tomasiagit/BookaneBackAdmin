<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    //
    protected $fillable = [
        'disciplina','classe','classe_id','arquivo'
    ];
}
