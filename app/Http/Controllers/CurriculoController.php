<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CurriculoController extends Controller
{
    // salvar via público
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'mensagem' => 'nullable|string',
            'curriculo' => 'required|mimes:pdf|max:5000'
        ]);

        // nome original
        $nomeOriginal = $request->file('curriculo')->getClientOriginalName();

        // conteúdo do pdf
        $conteudo = file_get_contents($request->file('curriculo')->getRealPath());

        // criptografar
        $criptografado = Crypt::encrypt($conteudo);

        // salvar arquivo criptografado
        $nomeCriptografado = time() . '_' . uniqid() . '.enc';
        Storage::disk('local')->put('curriculos/' . $nomeCriptografado, $criptografado);

        Curriculo::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'area' => $request->area,
            'mensagem' => $request->mensagem,
            'arquivo_nome' => $nomeOriginal,
            'arquivo_encrypted' => $nomeCriptografado
        ]);

        return response()->json(['status' => 'sucesso']);
    }

    // listar no admin
    public function index()
    {
        $curriculos = Curriculo::orderBy('created_at', 'desc')->get();
        return view('admin.curriculos.index', compact('curriculos'));
    }

    // download seguro
    public function download(Curriculo $curriculo)
    {
        $arquivo = Storage::disk('local')->get('curriculos/' . $curriculo->arquivo_encrypted);

        // descriptografar
        $conteudo = Crypt::decrypt($arquivo);

        return response($conteudo)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="'.$curriculo->arquivo_nome.'"');
    }
}

