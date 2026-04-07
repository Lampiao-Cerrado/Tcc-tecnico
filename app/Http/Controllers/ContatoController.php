<?php

namespace App\Http\Controllers;

use App\Models\Contato;

class ContatoController extends Controller
{
    public function index()
    {
        $contato = Contato::first();

        return view('site.contatos', compact('contato'));
    }
}
