<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'encrypted_nome',
        'encrypted_telefone',
        'encrypted_email',
        'encrypted_data_visita',
        'encrypted_hora',
        'encrypted_mensagem',
        'encrypted_key',
    ];
}
