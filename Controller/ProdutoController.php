<?php

require_once __DIR__ . '/../Model/ProdutoModel.php';

class ProdutoController
{
    private ProdutoModel $produtoModel;

    public function __construct(PDO $pdo)
    {
        $this->produtoModel = new ProdutoModel($pdo);
    }

    public function listar(string $termo = ''): array
    {
        return $this->produtoModel->buscar($termo);
    }

    public function buscarPorId(int $id): array|false
    {
        return $this->produtoModel->buscarPorId($id);
    }

    public function listarAtivosEmOrdemAlfabetica(): array
    {
        $produtos = $this->produtoModel->listarAtivos();
        usort($produtos, fn(array $a, array $b) => strcasecmp($a['nome'], $b['nome']));
        return $produtos;
    }

    public function salvar(array $entrada): array
    {
        $id = (int) ($entrada['id_produto'] ?? 0);
        $pesoInformado = $entrada['peso'] ?? '';
        $quantidadeInformada = $entrada['quantidade_estoque'] ?? '';
        $estoqueMinimoInformado = $entrada['estoque_minimo'] ?? '';

        $peso = filter_var($pesoInformado, FILTER_VALIDATE_FLOAT);
        $quantidade = filter_var($quantidadeInformada, FILTER_VALIDATE_INT);
        $estoqueMinimo = filter_var($estoqueMinimoInformado, FILTER_VALIDATE_INT);

        $produto = [
            'id_produto' => $id,
            'nome' => trim($entrada['nome'] ?? ''),
            'descricao' => trim($entrada['descricao'] ?? ''),
            'categoria' => trim($entrada['categoria'] ?? ''),
            'material' => trim($entrada['material'] ?? ''),
            'tamanho' => trim($entrada['tamanho'] ?? ''),
            'peso' => $peso === false ? $pesoInformado : $peso,
            'caracteristicas' => trim($entrada['caracteristicas'] ?? ''),
            'quantidade_estoque' => $quantidade === false ? $quantidadeInformada : $quantidade,
            'estoque_minimo' => $estoqueMinimo === false ? $estoqueMinimoInformado : $estoqueMinimo,
            'ativo' => isset($entrada['ativo']) ? 1 : 0
        ];

        $erros = [];

        if ($produto['nome'] === '' || $produto['categoria'] === '' || $produto['material'] === '' || $produto['tamanho'] === '') {
            $erros[] = 'Nome, categoria, material e tamanho são obrigatórios.';
        }
        if ($peso === false || $peso <= 0) {
            $erros[] = 'Informe um peso maior que zero.';
        }
        if ($quantidade === false || $quantidade < 0 || $estoqueMinimo === false || $estoqueMinimo < 0) {
            $erros[] = 'Estoque e estoque mínimo devem ser números inteiros iguais ou maiores que zero.';
        }

        if ($erros) {
            return ['erros' => $erros, 'produto' => $produto, 'mensagem' => ''];
        }

        $dados = $produto;
        unset($dados['id_produto']);

        if ($id > 0) {
            $this->produtoModel->editar($id, $dados);
            $mensagem = 'Produto alterado com sucesso.';
        } else {
            $this->produtoModel->cadastrar($dados);
            $mensagem = 'Produto cadastrado com sucesso.';
        }

        return ['erros' => [], 'produto' => $this->produtoVazio(), 'mensagem' => $mensagem];
    }

    public function excluir(int $id): string
    {
        try {
            $this->produtoModel->excluir($id);
            return 'Produto excluído com sucesso.';
        } catch (PDOException $e) {
            return 'O produto não pode ser excluído porque possui movimentações.';
        }
    }

    public function produtoVazio(): array
    {
        return [
            'id_produto' => '', 'nome' => '', 'descricao' => '', 'categoria' => '',
            'material' => '', 'tamanho' => '', 'peso' => '', 'caracteristicas' => '',
            'quantidade_estoque' => 0, 'estoque_minimo' => 0, 'ativo' => 1
        ];
    }
}
