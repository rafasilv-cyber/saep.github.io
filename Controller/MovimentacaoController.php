<?php

require_once __DIR__ . '/../Model/MovimentacaoModel.php';

class MovimentacaoController
{
    private MovimentacaoModel $movimentacaoModel;

    public function __construct(PDO $pdo)
    {
        $this->movimentacaoModel = new MovimentacaoModel($pdo);
    }

    public function registrar(array $entrada, int $idUsuario): string
    {
        $dataRecebida = $entrada['data_movimentacao'] ?? '';
        $data = str_replace('T', ' ', $dataRecebida);

        if (!$dataRecebida || strtotime($data) === false) {
            throw new InvalidArgumentException('Informe uma data válida.');
        }

        return $this->movimentacaoModel->registrar(
            (int) ($entrada['id_produto'] ?? 0),
            $idUsuario,
            $entrada['tipo'] ?? '',
            (int) ($entrada['quantidade'] ?? 0),
            $data,
            trim($entrada['observacao'] ?? '')
        );
    }

    public function listarHistorico(): array
    {
        return $this->movimentacaoModel->listarHistorico();
    }
}
