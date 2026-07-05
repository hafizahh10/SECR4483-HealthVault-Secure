<?php
// crypto_vault.php - Secure Medical Record Encryption

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $medical_payload = $_POST['payload'] ?? '';

    $key = $_ENV['APP_KEY'];

    $iv = random_bytes(12);

    $ciphertext = openssl_encrypt(
        $medical_payload,
        'aes-256-gcm',
        $key,
        OPENSSL_RAW_DATA,
        $iv,
        $tag
    );

    $serializedPayload = base64_encode(
        $iv .
        $tag .
        $ciphertext
    );

    echo json_encode([
        "status" => "vaulted",
        "data" => $serializedPayload
    ]);
}
?>