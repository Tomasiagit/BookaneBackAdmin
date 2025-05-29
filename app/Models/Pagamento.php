<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    //
    protected $fillable = [
        'id_user','id_pacote','estado','data_inicio','data_fim'

    ];
}
