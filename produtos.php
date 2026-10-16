<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/DB/Database.php';
require_once __DIR__ . '/Controller/ProdutoController.php';

$produtoController = new ProdutoController($pdo);
$erros = [];
$produtoEmEdicao = $produtoController->produtoVazio();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'excluir') {
        $_SESSION['mensagem'] = $produtoController->excluir((int) ($_POST['id_produto'] ?? 0));

        header('Location: produtos.php');
        exit;
    }

    if ($acao === 'salvar') {
        $resultado = $produtoController->salvar($_POST);
        $erros = $resultado['erros'];
        $produtoEmEdicao = $resultado['produto'];

        if (!$erros) {
            $_SESSION['mensagem'] = $resultado['mensagem'];
            header('Location: produtos.php');
            exit;
        }
    }
}

if (isset($_GET['editar'])) {
    $produtoEmEdicao = $produtoController->buscarPorId((int) $_GET['editar']) ?: $produtoController->produtoVazio();
}

$termo = trim($_GET['busca'] ?? '');
$produtos = $produtoController->listar($termo);
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

require __DIR__ . '/View/Produto/index.php';
