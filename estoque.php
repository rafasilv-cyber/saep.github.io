<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/DB/Database.php';
require_once __DIR__ . '/Controller/ProdutoController.php';
require_once __DIR__ . '/Controller/MovimentacaoController.php';

$produtoController = new ProdutoController($pdo);
$movimentacaoController = new MovimentacaoController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $_SESSION['mensagem_estoque'] = $movimentacaoController->registrar($_POST, (int) $_SESSION['usuario_id']);
    } catch (Throwable $erro) {
        $_SESSION['mensagem_estoque'] = $erro->getMessage();
    }

    header('Location: estoque.php');
    exit;
}

$produtos = $produtoController->listarAtivosEmOrdemAlfabetica();
$historico = $movimentacaoController->listarHistorico();
$mensagem = $_SESSION['mensagem_estoque'] ?? '';
unset($_SESSION['mensagem_estoque']);

require __DIR__ . '/View/Estoque/index.php';
