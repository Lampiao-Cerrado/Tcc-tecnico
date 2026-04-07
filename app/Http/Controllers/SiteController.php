<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListaMaterial;

class SiteController extends Controller
{
    public function historia()
    {
        return view('site.historia');
    }

    public function bercario()
    {
        $lista = ListaMaterial::where('turma', 'bercario')->first();
        return view('site.bercario', compact('lista'));
    }

    public function educacaoInfantil()
    {
        $lista = ListaMaterial::where('turma', 'infantil')->first();
        return view('site.educacao-infantil', compact('lista'));
    }

    public function ensinoFundamental()
    {
        $lista = ListaMaterial::where('turma', 'fundamental')->first();
        return view('site.ensino-fundamental', compact('lista'));
    }
}
