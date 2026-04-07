<?php

namespace App\Services;

use RuntimeException;

class CryptoService
{
    protected string $publicKeyPath;
    protected string $privateKeyPath;

    public function __construct()
    {
        $this->privateKeyPath = storage_path('keys/private.pem');
        $this->publicKeyPath = storage_path('keys/public.pem');

        if (!file_exists($this->publicKeyPath) || !file_exists($this->privateKeyPath)) {
            throw new RuntimeException('Chaves RSA não encontradas em storage/keys.');
        }
    }

    /**
     * Gera uma chave AES-256-GCM aleatória (32 bytes) e retorna binary.
     */
    protected function generateAesKey(): string
    {
        return random_bytes(32);
    }

    /**
     * Encriptar um texto (string) com AES-256-GCM retornando array com base64: ciphertext, iv, tag
     */
    public function encryptWithAes(string $plaintext, string $key): array
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($ciphertext === false) {
            throw new RuntimeException('Erro ao encriptar via AES.');
        }
        return [
            'ciphertext' => base64_encode($ciphertext),
            'iv' => base64_encode($iv),
            'tag' => base64_encode($tag),
        ];
    }

    /**
     * Decrypt AES bundle (expects base64 ciphertext, iv, tag)
     */
    public function decryptWithAes(array $bundle, string $key): string
    {
        $ciphertext = base64_decode($bundle['ciphertext']);
        $iv = base64_decode($bundle['iv']);
        $tag = base64_decode($bundle['tag']);
        $plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($plaintext === false) {
            throw new RuntimeException('Falha na descriptografia AES.');
        }
        return $plaintext;
    }

    /**
     * Encripta o conteúdo binário (arquivo) com AES-256-GCM e devolve array (ciphertext base64, iv, tag)
     * Nota: trabalha com string $data (binária).
     */
    public function encryptBinaryWithAes(string $data, string $key): array
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt($data, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($ciphertext === false) throw new RuntimeException('Erro encryptBinaryWithAes');
        return [
            'ciphertext' => base64_encode($ciphertext),
            'iv' => base64_encode($iv),
            'tag' => base64_encode($tag),
        ];
    }

    public function decryptBinaryWithAes(array $bundle, string $key): string
    {
        return $this->decryptWithAes($bundle, $key);
    }

    /**
     * Encripta (RSA-OAEP) a chave AES com a public key e retorna base64
     */
    public function encryptAesKeyWithRsa(string $aesKey): string
    {
        $pub = openssl_pkey_get_public(file_get_contents($this->publicKeyPath));
        if (!$pub) throw new RuntimeException('Erro ao carregar chave pública RSA.');
        $ok = openssl_public_encrypt($aesKey, $encrypted, $pub, OPENSSL_PKCS1_OAEP_PADDING);
        openssl_free_key($pub);
        if (!$ok) throw new RuntimeException('Falha ao encriptar AES key com RSA.');
        return base64_encode($encrypted);
    }

    /**
     * Desencripta a chave AES usando a private key (RSA-OAEP)
     */
    public function decryptAesKeyWithRsa(string $encryptedKeyBase64): string
    {
        $private = openssl_pkey_get_private(file_get_contents($this->privateKeyPath));
        if (!$private) throw new RuntimeException('Erro ao carregar chave privada RSA.');
        $enc = base64_decode($encryptedKeyBase64);
        $ok = openssl_private_decrypt($enc, $decrypted, $private, OPENSSL_PKCS1_OAEP_PADDING);
        openssl_free_key($private);
        if (!$ok) throw new RuntimeException('Falha ao descriptografar AES key com RSA.');
        return $decrypted;
    }
}
