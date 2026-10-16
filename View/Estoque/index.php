<?php
function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de estoque</title>
</head>
<body>
    <h1>Gestão de estoque</h1>
    <p><a href="principal.php">Voltar ao menu principal</a></p>

    <?php if ($mensagem): ?><p><?= e($mensagem) ?></p><?php endif; ?>

    <h2>Nova movimentação</h2>
    <form method="post">
        <p>
            <label>Produto<br>
                <select name="id_produto" required>
                    <option value="">Selecione</option>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= e($produto['id_produto']) ?>">
                            <?= e($produto['nome']) ?> - estoque: <?= e($produto['quantidade_estoque']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <p>
            <label>Tipo<br>
                <select name="tipo" required>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
            </label>
        </p>
        <p><label>Quantidade<br><input type="number" name="quantidade" min="1" required></label></p>
        <p><label>Data<br><input type="datetime-local" name="data_movimentacao" value="<?= date('Y-m-d\TH:i') ?>" required></label></p>
        <p><label>Observação<br><textarea name="observacao"></textarea></label></p>
        <button type="submit">Registrar movimentação</button>
    </form>

    <h2>Produtos em ordem alfabética</h2>
    <table border="1" cellpadding="5">
        <tr><th>Produto</th><th>Estoque atual</th><th>Estoque mínimo</th><th>Situação</th></tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= e($produto['nome']) ?></td>
                <td><?= e($produto['quantidade_estoque']) ?></td>
                <td><?= e($produto['estoque_minimo']) ?></td>
                <td><?= $produto['quantidade_estoque'] < $produto['estoque_minimo'] ? 'Abaixo do mínimo' : 'Normal' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Histórico de movimentações</h2>
    <table border="1" cellpadding="5">
        <tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Responsável</th><th>Observação</th></tr>
        <?php foreach ($historico as $movimentacao): ?>
            <tr>
                <td><?= e(date('d/m/Y H:i', strtotime($movimentacao['data_movimentacao']))) ?></td>
                <td><?= e($movimentacao['produto']) ?></td>
                <td><?= e(ucfirst($movimentacao['tipo'])) ?></td>
                <td><?= e($movimentacao['quantidade']) ?></td>
                <td><?= e($movimentacao['usuario']) ?></td>
                <td><?= e($movimentacao['observacao']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
