<?php

class aes {
    private static $method = 'AES-256-CBC';

    static function encrypt_string($plain_text, $encryption_key = null, $encryption_iv = null){
        global $default_encryption_key, $default_encryption_iv; //from the settings file

        if($encryption_key === null) $encryption_key = $default_encryption_key;
        if($encryption_iv === null) $encryption_iv = $default_encryption_iv;

        return base64_encode(openssl_encrypt($plain_text, self::$method, $encryption_key, OPENSSL_RAW_DATA, $encryption_iv));
    }

    static function decrypt_string($cipher_text, $encryption_key = null, $encryption_iv = null){
        global $default_encryption_key, $default_encryption_iv;

        if($encryption_key === null) $encryption_key = $default_encryption_key;
        if($encryption_iv === null) $encryption_iv = $default_encryption_iv;

        return openssl_decrypt(base64_decode($cipher_text), self::$method, $encryption_key, OPENSSL_RAW_DATA, $encryption_iv);
    }
}