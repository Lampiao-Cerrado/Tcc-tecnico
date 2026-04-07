<?php

namespace App\Helpers;

class CryptoHelper
{
    public static function decrypt($jsonData, $encryptedAesKey)
    {
        if (!$jsonData || !$encryptedAesKey) return null;

        try {
            // Decodifica JSON salvo no banco
            $payload = json_decode($jsonData, true);

            if (!$payload || !isset($payload['iv']) || !isset($payload['data'])) {
                return null; // Formato inválido
            }

            $iv = base64_decode($payload['iv']);
            $ciphertext = base64_decode($payload['data']);

            // ==== 1) DESCRIPTOGRAFAR CHAVE AES (RSA) ====
            $privateKey = openssl_pkey_get_private(file_get_contents(storage_path('app/keys/private.pem')));

            if (!$privateKey) return null;

            $aesKey = null;
            openssl_private_decrypt(base64_decode($encryptedAesKey), $aesKey, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);

            if (!$aesKey) return null;

            // ==== 2) DESCRIPTOGRAFAR DADO (AES) ====
            $cipher = "AES-256-CBC";

            return openssl_decrypt(
                $ciphertext,
                $cipher,
                $aesKey,
                OPENSSL_RAW_DATA,
                $iv
            );

        } catch (\Exception $e) {
            return null;
        }
    }
}
