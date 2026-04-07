<?php

namespace App\Http\Controllers;

use App\Models\PreMatricula;
use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicPreMatriculaController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    public function form()
    {
        return view('site.prematricula');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomeCrianca' => 'required|string|max:191',
            'dataNascimento' => 'required|date',
            'nomeResponsavel' => 'required|string|max:191',
            'telefone' => 'required|string|max:40',
            'email' => 'required|email|max:191',
            'turma' => 'required|string|max:50',
            'periodo' => 'required|string|max:50',
            'aceite_privacidade_prematricula' => 'required|accepted',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Criar chave AES
        $aesKey = random_bytes(32);

        // Criptografar campos
        $nomeCrianca    = $this->crypto->encryptWithAes($request->nomeCrianca, $aesKey);
        $dataNascimento = $this->crypto->encryptWithAes($request->dataNascimento, $aesKey);
        $nomeResp       = $this->crypto->encryptWithAes($request->nomeResponsavel, $aesKey);
        $telefone       = $this->crypto->encryptWithAes($request->telefone, $aesKey);
        $email          = $this->crypto->encryptWithAes($request->email, $aesKey);
        $turma          = $this->crypto->encryptWithAes($request->turma, $aesKey);
        $periodo        = $this->crypto->encryptWithAes($request->periodo, $aesKey);

        // Criptografar chave AES com RSA
        $encryptedAesKey = $this->crypto->encryptAesKeyWithRsa($aesKey);

        // Salvar no banco
        PreMatricula::create([
            'encrypted_nome_crianca'     => json_encode($nomeCrianca),
            'encrypted_data_nascimento'  => json_encode($dataNascimento),
            'encrypted_nome_responsavel' => json_encode($nomeResp),
            'encrypted_telefone'         => json_encode($telefone),
            'encrypted_email'            => json_encode($email),
            'encrypted_turma'            => json_encode($turma),
            'encrypted_periodo'          => json_encode($periodo),
            'encrypted_key'              => $encryptedAesKey,
        ]);

        return back()->with('success', 'Pré-matrícula enviada com sucesso!');
    }
}
