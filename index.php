<?php
session_start();

require_once __DIR__ . '/DB/Database.php';
require_once __DIR__ . '/Controller/UsuarioController.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: principal.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuarioController = new UsuarioController($pdo);
    $resultado = $usuarioController->autenticar($email, $senha);

    if ($resultado['usuario']) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $resultado['usuario']['id_usuario'];
        $_SESSION['usuario_nome'] = $resultado['usuario']['nome'];
        header('Location: principal.php');
        exit;
    }

    $_SESSION['erro_login'] = $resultado['erro'];

    header('Location: index.php');
    exit;
}

$erro = $_SESSION['erro_login'] ?? '';
unset($_SESSION['erro_login']);

require __DIR__ . '/View/Login/index.php';
