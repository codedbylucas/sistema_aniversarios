<?php

require_once __DIR__ . '/../config/DBConnection.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO implements IUsuarioDAO
{
    private $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    public function adicionar(Usuario $usuario) {
        $sql = $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)');
        $sql->bindValue(':nome', $usuario->getNome());
        $sql->bindValue(':email', $usuario->getEmail());
        $sql->bindValue(':senha', $usuario->getSenha());
        $sql->execute();
    }
    public function atualizar(Usuario $usuario) {}
    public function deletar($id) {}
    public function buscarPorId($id) {}

    public function buscarPorEmail($email) {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $usuario = new Usuario();
            $usuario->setNome($data['nome']);
            $usuario->setEmail($data['email']);
            $usuario->setSenha($data['senha']);
            $usuario->setId($data['id']);

            return $usuario;
        }
        
        return false;
    }
}
