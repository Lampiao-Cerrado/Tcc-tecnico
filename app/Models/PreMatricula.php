<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreMatricula extends Model
{
    protected $table = 'prematriculas';

    protected $fillable = [
        'encrypted_nome_crianca',
        'encrypted_data_nascimento',
        'encrypted_nome_responsavel',
        'encrypted_telefone',
        'encrypted_email',
        'encrypted_turma',
        'encrypted_periodo',
        'encrypted_key'
    ];
}
