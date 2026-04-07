<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use App\Models\PreMatricula;
use App\Models\Agendamento;
use App\Services\CryptoService;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminFormController extends Controller
{
    protected $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    private function decryptField($encryptedValue, $encryptedKey)
    {
        if (!$encryptedValue || !$encryptedKey) return null;

        try {
            // 1) Primeiro tenta decodificar normalmente
            $bundle = json_decode($encryptedValue, true);

            // 2) Se falhou, pode estar com aspas duplicadas
            if (!is_array($bundle)) {

                // Remove aspas duplicadas e barras extras
                $fixed = trim($encryptedValue, "\"");
                $fixed = stripslashes($fixed);

                $bundle = json_decode($fixed, true);
            }

            // 3) Se mesmo assim não for array → dado inválido
            if (!is_array($bundle)) {
                return null;
            }

            // 4) Descriptografar a AES key (RSA)
            $aesKey = $this->crypto->decryptAesKeyWithRsa($encryptedKey);

            // 5) Descriptografar campo AES-256-GCM
            return $this->crypto->decryptWithAes($bundle, $aesKey);

        } catch (\Exception $e) {
            return null;
        }
    }

    private function calcAge($date)
    {
        if (!$date) return null;
        $nasc = new \DateTime($date);
        $today = new \DateTime(date('Y-m-d'));
        return $nasc->diff($today)->y;
    }

    /* ================================================================
     * 1. CURRÍCULOS
     * ================================================================ */
    public function curriculos()
    {
        $dados = Curriculo::orderBy('created_at', 'desc')->get();

        foreach ($dados as $c) {
            $key = $c->encrypted_key;

            $c->nome     = $this->decryptField($c->encrypted_nome,             $key);
            $c->email    = $this->decryptField($c->encrypted_email,            $key);
            $c->telefone = $this->decryptField($c->encrypted_telefone,         $key);
            $c->cargo    = $this->decryptField($c->encrypted_area_interesse,   $key);
            $c->mensagem = $this->decryptField($c->encrypted_mensagem,         $key);
        }

        return response()->json($dados);
    }

    /* ================================================================
     * 2. PRÉ-MATRÍCULAS
     * ================================================================ */
    public function prematriculas()
    {
        $dados = PreMatricula::orderBy('created_at', 'desc')->get();

        foreach ($dados as $p) {

            $key = $p->encrypted_key;

            $p->responsavel = $this->decryptField($p->encrypted_nome_responsavel, $key);
            $p->crianca     = $this->decryptField($p->encrypted_nome_crianca,     $key);
            $p->data_nasc   = $this->decryptField($p->encrypted_data_nascimento,  $key);
            $p->telefone    = $this->decryptField($p->encrypted_telefone,         $key);
            $p->email       = $this->decryptField($p->encrypted_email,            $key);
            $p->turma       = $this->decryptField($p->encrypted_turma,            $key);
            $p->periodo     = $this->decryptField($p->encrypted_periodo,          $key);

            // agora idade funciona
            $p->idade = $this->calcAge($p->data_nasc);
        }

        return response()->json($dados);
    }

    /* ================================================================
     * 3. AGENDAMENTOS
     * ================================================================ */
    public function agendamentos()
    {
        $dados = Agendamento::orderBy('created_at', 'desc')->get();

        foreach ($dados as $a) {

            $key = $a->encrypted_key;

            $a->nome        = $this->decryptField($a->encrypted_nome,        $key);
            $a->telefone    = $this->decryptField($a->encrypted_telefone,    $key);
            $a->email       = $this->decryptField($a->encrypted_email,       $key);
            $a->data_visita = $this->decryptField($a->encrypted_data_visita, $key);

            // 🔥 este é o ajuste fundamental:
            $a->hora    = $this->decryptField($a->encrypted_hora,        $key);

            $a->mensagem    = $this->decryptField($a->encrypted_mensagem,    $key);

            $a->status = $a->status ?? "Pendente";

        }

        return response()->json($dados);
    }

    /* ================================================================
     * 4. DETALHES (Modal)
     * ================================================================ */
    public function detalhes($tipo, $id)
    {
        $model = match ($tipo) {
            'curriculo'    => Curriculo::findOrFail($id),
            'prematricula' => PreMatricula::findOrFail($id),
            'agendamento'  => Agendamento::findOrFail($id),
            default        => abort(404),
        };

        $key = $model->encrypted_key;

        foreach ($model->getAttributes() as $campo => $valor) {

            if (str_starts_with($campo, 'encrypted_')) {

                try {
                    $model->{str_replace("encrypted_", "", $campo)} =
                        $this->decryptField($valor, $key);

                } catch (\Exception $e) {
                    $model->{str_replace("encrypted_", "", $campo)} = null;
                }
            }
        }

        return response()->json($model);
    }

    public function downloadCurriculo($id)
    {
        $registro = Curriculo::findOrFail($id);

        // caminho salvo no banco (ex: 'curriculos/abcd.bin' ou arquivo JSON com bundle)
        if (empty($registro->file_path)) {
            return abort(404, 'Arquivo não encontrado (file_path vazio).');
        }

        $fullPath = storage_path('app/' . ltrim($registro->file_path, '/'));

        if (!file_exists($fullPath)) {
            return abort(404, 'Arquivo não encontrado no storage.');
        }

        // Ler conteúdo do arquivo
        $contents = file_get_contents($fullPath);
        if ($contents === false) {
            return abort(500, 'Falha ao ler o arquivo no servidor.');
        }

        // Detectar se o arquivo é um JSON bundle AES (ciphertext, iv, tag)
        $maybeJson = json_decode($contents, true);

        // se for bundle AES e existir encrypted_key no registro => descriptografar antes de enviar
        if (is_array($maybeJson) && isset($maybeJson['ciphertext']) && !empty($registro->encrypted_key)) {

            try {
                // descriptografa a AES key com RSA
                $aesKey = $this->crypto->decryptAesKeyWithRsa($registro->encrypted_key);

                // descriptografa o binário
                $decrypted = $this->crypto->decryptBinaryWithAes($maybeJson, $aesKey);

            } catch (\Exception $e) {
                \Log::error('Erro ao descriptografar arquivo curriculo: '.$e->getMessage());
                return abort(500, 'Erro ao descriptografar o arquivo.');
            }

            // checar SHA se existir no registro (opcional)
            if (!empty($registro->file_sha256)) {
                $sha = hash('sha256', $decrypted);
                if ($sha !== $registro->file_sha256) {
                    \Log::warning("SHA mismatch for curriculo {$registro->id}: expected {$registro->file_sha256} got {$sha}");
                    // você pode abortar ou continuar; aqui enviaremos mas registramos
                }
            }

            // enviar conteúdo descriptografado usando response stream temporário e apagar depois
            $tmp = tempnam(sys_get_temp_dir(), 'cv_');
            file_put_contents($tmp, $decrypted);

            $name = $registro->file_original_name ?? ('curriculo_'.$registro->id.'.pdf');

            return response()->download($tmp, $name)->deleteFileAfterSend(true);

        } else {
            // Não é JSON bundle — serve o arquivo diretamente
            $name = $registro->file_original_name ?? basename($fullPath);
            return response()->download($fullPath, $name);
        }
    }

    public function confirmarAgendamento($id)
    {
        $ag = Agendamento::findOrFail($id);

        $ag->status = "Confirmado";
        $ag->save();

        return response()->json(['success' => true]);
    }


    

}
