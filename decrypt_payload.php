<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function decryptPayload($payload)
{
    $key = $_ENV['APP_KEY'];

    $decoded = base64_decode($payload);

    $iv = substr($decoded, 0, 12);

    $tag = substr($decoded, 12, 16);

    $ciphertext = substr($decoded, 28);

    $plaintext = openssl_decrypt(
        $ciphertext,
        'aes-256-gcm',
        $key,
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );

    if ($plaintext === false) {

        throw new Exception(
            "Authentication verification failed."
        );
    }

    return $plaintext;
}
?>