<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use App\Services\CryptoService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCurriculoController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * Lista todos os currículos criptografados
     */
    public function index()
    {
        $items = Curriculo::latest()->paginate(15);

        return view('admin.curriculos.index', compact('items'));
    }

    /**
     * Mostra um currículo descriptografado no painel admin
     */
    public function show($id)
    {
        $curriculo = Curriculo::findOrFail($id);

        // descriptografar chave AES usando RSA
        $aesKey = $this->crypto->decryptAesKeyWithRsa($curriculo->encrypted_key);

        // descriptografar campos
        $nome = $this->crypto->decryptWithAes(json_decode($curriculo->encrypted_nome, true), $aesKey);
        $email = $this->crypto->decryptWithAes(json_decode($curriculo->encrypted_email, true), $aesKey);
        $telefone = $this->crypto->decryptWithAes(json_decode($curriculo->encrypted_telefone, true), $aesKey);
        $area = $this->crypto->decryptWithAes(json_decode($curriculo->encrypted_area_interesse, true), $aesKey);
        $mensagem = $this->crypto->decryptWithAes(json_decode($curriculo->encrypted_mensagem, true), $aesKey);

        return view('admin.curriculos.show', compact(
            'curriculo', 'nome', 'email', 'telefone', 'area', 'mensagem'
        ));
    }

    /**
     * Baixa o PDF descriptografado
     */
    public function download($id)
    {
        $curriculo = Curriculo::findOrFail($id);

        if (!Storage::disk('local')->exists($curriculo->file_path)) {
            abort(404, "Arquivo não encontrado.");
        }

        // carregar arquivo .json criptografado
        $jsonContent = Storage::disk('local')->get($curriculo->file_path);
        $fileBundle = json_decode($jsonContent, true);

        if (!$fileBundle || !isset($fileBundle['ciphertext'], $fileBundle['iv'], $fileBundle['tag'])) {
            abort(500, "Arquivo criptografado malformado.");
        }

        // descriptografar a AES key
        $aesKey = $this->crypto->decryptAesKeyWithRsa($curriculo->encrypted_key);

        // descriptografar PDF binário
        $binary = $this->crypto->decryptBinaryWithAes($fileBundle, $aesKey);

        // retornar arquivo para download
        return new StreamedResponse(function () use ($binary) {
            echo $binary;
        }, 200, [
            "Content-Type" => "application/pdf",
            "Content-Disposition" => "attachment; filename=\"{$curriculo->file_original_name}\""
        ]);
    }
}
