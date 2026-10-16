<?php

class MovimentacaoModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function registrar(
        int $idProduto,
        int $idUsuario,
        string $tipo,
        int $quantidade,
        string $data,
        string $observacao
    ): string {
        if (!in_array($tipo, ['entrada', 'saida'], true)) {
            throw new InvalidArgumentException('Tipo de movimentação inválido.');
        }

        if ($quantidade <= 0) {
            throw new InvalidArgumentException('A quantidade deve ser maior que zero.');
        }

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id_produto = ? FOR UPDATE');
            $stmt->execute([$idProduto]);
            $produto = $stmt->fetch();

            if (!$produto) {
                throw new InvalidArgumentException('Produto não encontrado.');
            }

            $estoqueAtual = (int) $produto['quantidade_estoque'];

            if ($tipo === 'saida' && $quantidade > $estoqueAtual) {
                throw new InvalidArgumentException('A quantidade de saída é maior que o estoque disponível.');
            }

            $novoEstoque = $tipo === 'entrada'
                ? $estoqueAtual + $quantidade
                : $estoqueAtual - $quantidade;

            $stmt = $this->pdo->prepare('UPDATE produtos SET quantidade_estoque = ? WHERE id_produto = ?');
            $stmt->execute([$novoEstoque, $idProduto]);

            $stmt = $this->pdo->prepare(
                'INSERT INTO movimentacoes
                 (id_produto, id_usuario, tipo, quantidade, data_movimentacao, observacao)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$idProduto, $idUsuario, $tipo, $quantidade, $data, $observacao]);

            $this->pdo->commit();

            if ($tipo === 'saida' && $novoEstoque < (int) $produto['estoque_minimo']) {
                return 'Movimentação registrada. Alerta: estoque abaixo do mínimo configurado.';
            }

            return 'Movimentação registrada com sucesso.';
        } catch (Throwable $erro) {
            $this->pdo->rollBack();
            throw $erro;
        }
    }

    public function listarHistorico(): array
    {
        $sql = 'SELECT m.*, p.nome AS produto, u.nome AS usuario
                FROM movimentacoes m
                INNER JOIN produtos p ON p.id_produto = m.id_produto
                INNER JOIN usuarios u ON u.id_usuario = m.id_usuario
                ORDER BY m.data_movimentacao DESC, m.id_movimentacao DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
