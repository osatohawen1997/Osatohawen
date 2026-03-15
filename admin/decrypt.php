<?php

require_once '../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../php/");
$dotenv->load();

$key = $_ENV['ENCRYPTION_KEY'];

// Encrypt function
function decryptData($data, $key) {

    [$ivEncoded, $encrypted] = explode(':', $data, 2);
    $iv = base64_decode($ivEncoded);
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);

}