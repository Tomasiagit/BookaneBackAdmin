<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    //
    protected $fillable = [
        'user_id','pacote_id','classe_id','estado','data_inicio','data_fim'

    ];
}
