<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicAgendamentoController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * MOSTRA O FORMULÁRIO (FALTANDO)
     */
    public function form()
    {
        return view('site.agendar-visita');
    }

    /**
     * PROCESSAR ENVIO (JÁ EXISTE)
     */
    public function submit(Request $request)
    {
        // Validação CORRIGIDA
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'telefone' => 'required|string|max:40',
            'data_visita' => 'required|date_format:Y-m-d',
            'hora' => 'required|string',
            'mensagem' => 'nullable|string|max:2000',
            'aceite_privacidade_agendamento' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Gerar chave AES
        $aesKey = random_bytes(32);

        // Criptografar campos
        $nome       = $this->crypto->encryptWithAes($request->nome, $aesKey);
        $email      = $this->crypto->encryptWithAes($request->email ?? '', $aesKey);
        $telefone   = $this->crypto->encryptWithAes($request->telefone, $aesKey);
        $dataVisita = $this->crypto->encryptWithAes($request->data_visita, $aesKey);
        $hora       = $this->crypto->encryptWithAes($request->hora, $aesKey);
        $mensagem   = $this->crypto->encryptWithAes($request->mensagem ?? '', $aesKey);

        // Encrypt AES key com RSA
        $encryptedAesKey = $this->crypto->encryptAesKeyWithRsa($aesKey);

        // Salvar
        Agendamento::create([
            'encrypted_nome'        => json_encode($nome),
            'encrypted_telefone'    => json_encode($telefone),
            'encrypted_email'       => json_encode($email),
            'encrypted_data_visita' => json_encode($dataVisita),
            'encrypted_hora'        => json_encode($hora),
            'encrypted_mensagem'    => json_encode($mensagem),
            'encrypted_key'         => $encryptedAesKey,
            'status'                => 'Pendente',
        ]);

        return redirect()->back()->with('success', 'Agendamento enviado com sucesso.');
    }
}