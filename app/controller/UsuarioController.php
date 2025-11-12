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

        if (!$email || !$senha) {
            echo json_encode(['success' => false, 'message' => 'Preencha email e senha.']);
            return;
        }

        if ($email && $senha) {

            $usuario = $this->usuarioDAO->buscarPorEmail($email);

            if ($usuario != false && password_verify($senha, $usuario->getSenha())) {
                $_SESSION['nome'] = $usuario->getNome();
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['usuario_id'] = $usuario->getId();

                // responda com JSON indicando sucesso e a URL para redirecionar
                echo json_encode(['success' => true, 'redirect' => '../view/dashboard.php']);
                return;
            } else {
                echo json_encode(['success' => false, 'message' => 'Email ou senha inválidos.']);
                return;
            }
        }
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'login') {
    $controller = new UsuarioController();
    $controller->processarLogin();
}
