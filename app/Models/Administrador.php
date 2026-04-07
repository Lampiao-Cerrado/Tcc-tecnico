<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    protected $table = 'administradores';
    protected $primaryKey = 'id_administrador';

    protected $fillable = [
        'nome_usuario',
        'email_admin',
        'senha'
    ];

    protected $hidden = [
        'senha'
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
