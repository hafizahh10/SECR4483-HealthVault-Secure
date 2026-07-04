<?php
// migrate_hashes.php

require_once 'db_config.php';

$users = [

    'dr_faizal' => 'testkey123',
    'dr_sharifah' => 'doctorsecret'
];

foreach($users as $username => $password){

    $argonHash = password_hash(
        $password,
        PASSWORD_ARGON2ID
    );

    $stmt = $pdo->prepare(
    "
    UPDATE staff_credentials
    SET auth_key_hash = ?
    WHERE username = ?
    "
    );

    $stmt->execute([
        $argonHash,
        $username
    ]);
}

echo "Migration completed.";