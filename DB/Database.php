<?php

$dsn = 'mysql:host=localhost;dbname=saep_db;charset=utf8mb4';
$usuarioBanco = 'root';
$senhaBanco = '';

try {
    $pdo = new PDO($dsn, $usuarioBanco, $senhaBanco, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die('Não foi possível conectar ao banco de dados.');
}
