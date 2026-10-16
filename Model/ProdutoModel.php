<?php

class ProdutoModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function buscar(string $termo = ''): array
    {
        if ($termo === '') {
            return $this->pdo->query('SELECT * FROM produtos ORDER BY id_produto')->fetchAll();
        }

        $sql = 'SELECT * FROM produtos
                WHERE nome LIKE :termo
                   OR categoria LIKE :termo
                   OR material LIKE :termo
                ORDER BY id_produto';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['termo' => '%' . $termo . '%']);
        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id_produto = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function listarAtivos(): array
    {
        return $this->pdo->query('SELECT * FROM produtos WHERE ativo = 1')->fetchAll();
    }

    public function cadastrar(array $dados): void
    {
        $sql = 'INSERT INTO produtos
                (nome, descricao, categoria, material, tamanho, peso, caracteristicas,
                 quantidade_estoque, estoque_minimo, ativo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($dados));
    }

    public function editar(int $id, array $dados): void
    {
        $sql = 'UPDATE produtos SET
                nome = ?, descricao = ?, categoria = ?, material = ?, tamanho = ?,
                peso = ?, caracteristicas = ?, quantidade_estoque = ?, estoque_minimo = ?, ativo = ?
                WHERE id_produto = ?';
        $stmt = $this->pdo->prepare($sql);
        $valores = array_values($dados);
        $valores[] = $id;
        $stmt->execute($valores);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM produtos WHERE id_produto = ?');
        $stmt->execute([$id]);
    }
}
