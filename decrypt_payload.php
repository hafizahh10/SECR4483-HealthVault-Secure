<?php

function decryptPayload(
    string $payload,
    string $key
): string {

    $decoded =
        base64_decode(
            $payload
        );

    $iv =
        substr(
            $decoded,
            0,
            12
        );

    $tag =
        substr(
            $decoded,
            12,
            16
        );

    $ciphertext =
        substr(
            $decoded,
            28
        );

    $plaintext =
        openssl_decrypt(
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