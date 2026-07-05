<?php
// db_config.php

$host = "localhost";
$dbname = "medic_vault_db";
$username = "medic_app";
$password = "StrongPassword123!";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    die("Database connection failed.");
}
?>