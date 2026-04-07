<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;

class AdminContatoController extends Controller
{
    public function index()
    {
        $contato = Contato::first();
        return view('admin.contato', compact('contato'));
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'telefone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'email'    => 'nullable|email|max:255',
        ]);

        $contato = Contato::firstOrNew(['id' => 1]);

        // Só atualiza se o campo vier preenchido
        if ($request->filled('telefone')) {
            $contato->telefone = $request->telefone;
        }

        if ($request->filled('whatsapp')) {
            $contato->whatsapp = $request->whatsapp;
        }

        if ($request->filled('email')) {
            $contato->email = $request->email;
        }

        $contato->save();

        return back()->with('status', 'Contatos atualizados com sucesso!');
    }

}
