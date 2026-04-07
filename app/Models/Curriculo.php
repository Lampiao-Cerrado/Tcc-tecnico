<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
    protected $table = 'curriculos';

    protected $fillable = [
        'encrypted_nome',
        'encrypted_email',
        'encrypted_telefone',
        'encrypted_area_interesse',
        'encrypted_mensagem',
        'encrypted_key',
        'file_path',
        'file_original_name',
        'file_sha256'
    ];
}
