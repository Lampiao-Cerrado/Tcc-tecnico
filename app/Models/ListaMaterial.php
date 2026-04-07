<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaMaterial extends Model
{
    protected $table = 'lista_materiais';

    protected $fillable = ['turma', 'arquivo',  'nomes_exibicao'];

    protected $casts = [
        'arquivo' => 'array',
        'nomes_exibicao' => 'array'
    ];
}
