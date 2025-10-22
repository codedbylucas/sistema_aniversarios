<?php

require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../config/DBConnection.php';

class CadastroController
{
    private $usuarioDAO;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->usuarioDAO = new UsuarioDAO($pdo);
    }

    public function cadastrarUsuario()
    {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if ($nome && $email && $senha) {
            if ($this->usuarioDAO->buscarPorEmail($email) == false) {
                $usuario = new Usuario();
                $usuario->setNome($nome);
                $usuario->setEmail($email);
                $usuario->setSenha($senha);
                $this->usuarioDAO->adicionar($usuario);

                header("Location: ../view/login.php?mensagem=Cadastro realizado com sucesso! Faça login para continuar.");
                exit;
            } else {
                header("Location: ../view/cadastrar.php?mensagem=Email já cadastrado. Por favor, utilize outro email.");
                exit;
            }
        } else {
            header("Location: ../view/cadastrar.php?=mensagem=Dados inválidos. Por favor, preencha todos os campos corretamente");
            exit;
        }
    }
}

$controller = new CadastroController();
$controller->cadastrarUsuario();
