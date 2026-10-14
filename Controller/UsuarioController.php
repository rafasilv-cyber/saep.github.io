<?php
require_once __DIR__ . '/../Model/UsuarioModel.php';
class UsuarioController {
    private $usuarioModel;
   
    public function __construct($pdo) {
        $this->usuarioModel = new UsuarioModel($pdo);

    }
    public function listar() {
        $usuarios = $this->usuarioModel->buscarTodos();
        include_once __DIR__ . '/../View/Usuario/listar.php';
        return;
    }

    public function buscarUsuario($id){
        $usuario = $this->usuarioModel->buscarUsuario($id);
        return $usuario;
    }

    public function cadastrar($nome, $email, $senha){
        $this->usuarioModel->cadastrar($nome, $email, $senha);
    }
    
    public function editar($nome,$email, $senha, $id){
        $this->usuarioModel->editar($nome, $email, $senha, $id);

    }

    public function deletar($id){
        $usuario = $this->usuarioModel->deletar($id);
        return $usuario;
    }

}








