<?php

require_once __DIR__ . '/../Model/UsuarioModel.php';

class UsuarioController
{
    private UsuarioModel $usuarioModel;

    public function __construct(PDO $pdo)
    {
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function autenticar(string $email, string $senha): array
    {
        if ($email === '' || $senha === '') {
            return ['usuario' => null, 'erro' => 'Preencha o e-mail e a senha.'];
        }

        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if (!$usuario) {
            return ['usuario' => null, 'erro' => 'E-mail não encontrado.'];
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return ['usuario' => null, 'erro' => 'Senha incorreta.'];
        }

        return ['usuario' => $usuario, 'erro' => ''];
    }
}
