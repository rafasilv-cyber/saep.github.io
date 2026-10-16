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
    <title>Cadastro de produtos</title>
</head>
<body>
    <h1>Cadastro de produtos</h1>
    <p><a href="principal.php">Voltar ao menu principal</a></p>

    <?php if ($mensagem): ?><p><?= e($mensagem) ?></p><?php endif; ?>
    <?php foreach ($erros as $erro): ?><p><?= e($erro) ?></p><?php endforeach; ?>

    <h2><?= $produtoEmEdicao['id_produto'] ? 'Editar produto' : 'Novo produto' ?></h2>
    <form method="post">
        <input type="hidden" name="acao" value="salvar">
        <input type="hidden" name="id_produto" value="<?= e($produtoEmEdicao['id_produto']) ?>">

        <p><label>Nome<br><input name="nome" value="<?= e($produtoEmEdicao['nome']) ?>" required></label></p>
        <p><label>Descrição<br><textarea name="descricao"><?= e($produtoEmEdicao['descricao']) ?></textarea></label></p>
        <p><label>Categoria<br><input name="categoria" value="<?= e($produtoEmEdicao['categoria']) ?>" required></label></p>
        <p><label>Material<br><input name="material" value="<?= e($produtoEmEdicao['material']) ?>" required></label></p>
        <p><label>Tamanho<br><input name="tamanho" value="<?= e($produtoEmEdicao['tamanho']) ?>" required></label></p>
        <p><label>Peso em kg<br><input type="number" name="peso" step="0.001" min="0.001" value="<?= e($produtoEmEdicao['peso']) ?>" required></label></p>
        <p><label>Características<br><textarea name="caracteristicas"><?= e($produtoEmEdicao['caracteristicas']) ?></textarea></label></p>
        <p><label>Quantidade em estoque<br><input type="number" name="quantidade_estoque" min="0" value="<?= e($produtoEmEdicao['quantidade_estoque']) ?>" required></label></p>
        <p><label>Estoque mínimo<br><input type="number" name="estoque_minimo" min="0" value="<?= e($produtoEmEdicao['estoque_minimo']) ?>" required></label></p>
        <p><label><input type="checkbox" name="ativo" <?= $produtoEmEdicao['ativo'] ? 'checked' : '' ?>> Produto ativo</label></p>
        <button type="submit">Salvar</button>
        <?php if ($produtoEmEdicao['id_produto']): ?><a href="produtos.php">Cancelar edição</a><?php endif; ?>
    </form>

    <h2>Produtos cadastrados</h2>
    <form method="get">
        <label>Buscar <input name="busca" value="<?= e($termo) ?>"></label>
        <button type="submit">Pesquisar</button>
        <a href="produtos.php">Limpar</a>
    </form>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th><th>Nome</th><th>Categoria</th><th>Material</th><th>Tamanho</th>
                <th>Peso</th><th>Estoque</th><th>Mínimo</th><th>Ativo</th><th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= e($produto['id_produto']) ?></td>
                <td><?= e($produto['nome']) ?></td>
                <td><?= e($produto['categoria']) ?></td>
                <td><?= e($produto['material']) ?></td>
                <td><?= e($produto['tamanho']) ?></td>
                <td><?= e($produto['peso']) ?> kg</td>
                <td><?= e($produto['quantidade_estoque']) ?></td>
                <td><?= e($produto['estoque_minimo']) ?></td>
                <td><?= $produto['ativo'] ? 'Sim' : 'Não' ?></td>
                <td>
                    <a href="produtos.php?editar=<?= e($produto['id_produto']) ?>">Editar</a>
                    <form method="post" style="display:inline" onsubmit="return confirm('Excluir este produto?')">
                        <input type="hidden" name="acao" value="excluir">
                        <input type="hidden" name="id_produto" value="<?= e($produto['id_produto']) ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$produtos): ?>
            <tr><td colspan="10">Nenhum produto encontrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
