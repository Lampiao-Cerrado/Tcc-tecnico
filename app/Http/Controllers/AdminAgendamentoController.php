<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Services\CryptoService;

class AdminAgendamentoController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    public function index()
    {
        $items = Agendamento::latest()->paginate(15);
        return view('admin.agendamentos.index', compact('items')); // ← CORRIGIDO
    }

    public function show(Agendamento $agendamento)
    {
        // Descriptografar chave AES
        $aesKey = $this->crypto->decryptAesKeyWithRsa($agendamento->encrypted_key);

        // Função segura para descriptografia
        $decrypt = function ($data) use ($aesKey) {
            if (!$data) return null;

            $decoded = json_decode($data, true);
            if (!$decoded) return null;

            return $this->crypto->decryptWithAes($decoded, $aesKey);
        };

        // Campos descriptografados
        $nome     = $decrypt($agendamento->encrypted_nome);
        $email    = $decrypt($agendamento->encrypted_email);
        $telefone = $decrypt($agendamento->encrypted_telefone);
        $data     = $decrypt($agendamento->encrypted_data_visita);
        $hora     = $decrypt($agendamento->encrypted_hora);
        $mensagem = $decrypt($agendamento->encrypted_mensagem);

        return view('admin.agendamentos.show', compact( // ← CORRIGIDO
            'agendamento', 'nome', 'email', 'telefone', 'data', 'hora', 'mensagem'
        ));
    }
}