<?php
// auth.php - Secure Staff Authentication

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $inputKey = trim($_POST['auth_key'] ?? '');

    if (mb_strlen($inputKey, 'UTF-8') > 256) {

        die("Invalid authentication key.");
    }

    $stmt = $pdo->prepare("
        SELECT auth_key_hash
        FROM staff_credentials
        WHERE username = ?
    ");

    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if (
        $user &&
        password_verify(
            $inputKey,
            $user['auth_key_hash']
        )
    ) {

        echo "Access Granted.";

    } else {

        echo "Access Denied.";
    }
}
?>