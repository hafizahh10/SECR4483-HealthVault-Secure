<?php

use PHPUnit\Framework\TestCase;

final class CryptoVaultTest
extends TestCase
{
    public function testEncryptionLifecycle()
    {
        $key = random_bytes(32);

        $plaintext =
            "Patient Record";

        $iv =
            random_bytes(12);

        $ciphertext =
            openssl_encrypt(
                $plaintext,
                'aes-256-gcm',
                $key,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );

        $decrypted =
            openssl_decrypt(
                $ciphertext,
                'aes-256-gcm',
                $key,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );

        $this->assertEquals(
            $plaintext,
            $decrypted
        );
    }

    public function testCredentialHashIntegrity()
    {
        $password =
            "doctorsecret";

        $hash =
            password_hash(
                $password,
                PASSWORD_ARGON2ID
            );

        $this->assertTrue(
            password_verify(
                $password,
                $hash
            )
        );
    }
}