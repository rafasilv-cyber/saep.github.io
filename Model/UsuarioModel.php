<?php

class UsuarioModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function buscarPorEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
