<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
</head>
<body>
    <h1>Menu principal</h1>
    <p>Usuário logado: <?= htmlspecialchars($_SESSION['usuario_nome']) ?></p>

    <nav>
        <a href="produtos.php">Cadastro de produtos</a> |
        <a href="estoque.php">Gestão de estoque</a> |
        <a href="logout.php">Sair</a>
    </nav>
</body>
</html>
