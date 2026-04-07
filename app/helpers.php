<?php

if (!function_exists('decrypt_aes')) {
    function decrypt_aes($value)
    {
        if (!$value) return null;

        return openssl_decrypt(
            base64_decode($value),
            'AES-256-CBC',
            env('AES_KEY'),
            0,
            env('AES_IV')
        );
    }
}
