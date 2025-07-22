<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    //
    protected $fillable = [
        'user_id','pacote_id','classe_id','classe','estado','data_inicio','data_fim'

    ];

    protected static function booted()
{
    static::creating(function ($pagamento) {
        if ($pagamento->classe_id && empty($pagamento->classe)) {
            $classe = \App\Models\Classe::find($pagamento->classe_id);
            $pagamento->classe = $classe ? $classe->nome : null;
        }
    });
}
}
