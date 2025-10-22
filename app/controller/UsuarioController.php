<?php
session_start();


require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../config/DBConnection.php';

class UsuarioController
{
    private $usuarioDAO;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->usuarioDAO = new UsuarioDAO($pdo);
    }

    public function processarLogin()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if ($email && $senha) {

            $usuario = $this->usuarioDAO->buscarPorEmail($email);

            if ($usuario != false && password_verify($senha, $usuario->getSenha())) {
                $_SESSION['nome'] = $usuario->getNome();
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['usuario_id'] = $usuario->getId();

                header("Location: ../view/dashboard.php");
                exit;
            } else {
                header("Location: ../view/login.php?erro=Email ou senha inválidos. Tente novamente.");
                exit;
            }
        }
    }
}

$login = new UsuarioController();
$login->processarLogin();
