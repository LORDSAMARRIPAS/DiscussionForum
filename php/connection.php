<?php
require_once 'config.php';
$pdo;

function getDbConfig() {
    $envFile = dirname(__DIR__) . '/.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            if (str_contains($line, '=')) {
                list($key, $value) = explode('=', $line, 2);
                $_ENV[trim($key)] = trim($value);
            }
        }
    }
    return [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'name' => $_ENV['DB_NAME'] ?? 'db_37431970',
        'user' => $_ENV['DB_USER'] ?? '37431970',
        'pass' => $_ENV['DB_PASS'] ?? '37431970',
    ];
}

function connectdb(){
    try {
        $cfg = getDbConfig();
        $connString = "mysql:host={$cfg['host']};dbname={$cfg['name']}";
        $pdo = new PDO($connString, $cfg['user'], $cfg['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(PDOException $e){
        return null;
    }
}

function closedb(){
    $pdo = null;
}

?>