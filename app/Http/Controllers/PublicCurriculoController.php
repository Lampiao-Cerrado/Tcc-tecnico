<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicCurriculoController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * Show form (Blade already created elsewhere). Route: GET /trabalhe-conosco
     */
    public function showForm()
    {
        return view('site.trabalhe-conosco');
    }

    /**
     * Processa submissão pública
     */
    public function submit(Request $request)
    {
        // validação básica de campos
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'telefone' => 'required|string|max:40',
            'area' => 'required|string|max:191',
            'mensagem' => 'nullable|string|max:2000',
            'curriculo' => 'required|file|max:5120|mimes:pdf', // size limite 5MB
            'aceite_privacidade' => 'required|accepted', 
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Segurança adicional no arquivo: verificação MIME real + header PDF
        $file = $request->file('curriculo');
        $tmpPath = $file->getRealPath();
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        if ($mime !== 'application/pdf') {
            return back()->withErrors(['curriculo' => 'Arquivo não é um PDF válido.'])->withInput();
        }

        // Byte header check
        $fh = fopen($tmpPath, 'rb');
        $header = fread($fh, 4);
        fclose($fh);
        if ($header !== '%PDF') {
            return back()->withErrors(['curriculo' => 'Arquivo PDF malformado ou inválido.'])->withInput();
        }

        // Lê conteúdo do PDF
        $binary = file_get_contents($tmpPath);

        // Gera chave AES e criptografa o arquivo (binary)
        $aesKey = random_bytes(32); // AES-256
        $encFileBundle = $this->crypto->encryptBinaryWithAes($binary, $aesKey);

        // Monta payload salvo em disco: vamos salvar JSON contendo ciphertext, iv, tag
        $storageDir = 'private/curriculos';
        $filename = Str::random(24) . '.enc.json'; // arquivo JSON com base64
        $payload = [
            'ciphertext' => $encFileBundle['ciphertext'],
            'iv' => $encFileBundle['iv'],
            'tag' => $encFileBundle['tag'],
        ];

        Storage::disk('local')->put($storageDir . '/' . $filename, json_encode($payload, JSON_UNESCAPED_SLASHES));

        // Protege a chave AES com RSA(public)
        $encryptedAesKey = $this->crypto->encryptAesKeyWithRsa($aesKey);

        // Calcula sha256 do arquivo original (para verificação)
        $sha256 = hash('sha256', $binary);

        // Cripta campos textuais (podemos usar AES para cada campo e depois guardar o bundle em base64)
        $aesKeyForFields = $aesKey; // reusar a mesma chave AES (válido) ou gerar outra; aqui reuso
        $nomeBundle = $this->crypto->encryptWithAes($request->input('nome'), $aesKeyForFields);
        $emailBundle = $this->crypto->encryptWithAes($request->input('email'), $aesKeyForFields);
        $telefoneBundle = $this->crypto->encryptWithAes($request->input('telefone'), $aesKeyForFields);
        $areaBundle = $this->crypto->encryptWithAes($request->input('area'), $aesKeyForFields);
        $mensagemBundle = $this->crypto->encryptWithAes($request->input('mensagem') ?? '', $aesKeyForFields);

        // Armazenar no DB: guardamos os bundles JSON (ciphertext|iv|tag) como JSON strings
        $curriculo = Curriculo::create([
            'encrypted_nome' => json_encode($nomeBundle),
            'encrypted_email' => json_encode($emailBundle),
            'encrypted_telefone' => json_encode($telefoneBundle),
            'encrypted_area_interesse' => json_encode($areaBundle),
            'encrypted_mensagem' => json_encode($mensagemBundle),
            'encrypted_key' => $encryptedAesKey,
            'file_path' => $storageDir . '/' . $filename,
            'file_original_name' => $file->getClientOriginalName(),
            'file_sha256' => $sha256,
        ]);

        return redirect()->route('trabalhe_conosco.form')->with('success', 'Currículo enviado com sucesso.');
    }
}
