<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Sistema de Gestão de Estoque</h1>

    <?php if ($erro): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="email">E-mail</label><br>
            <input type="email" id="email" name="email" required>
        </p>
        <p>
            <label for="senha">Senha</label><br>
            <input type="password" id="senha" name="senha" required>
        </p>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
