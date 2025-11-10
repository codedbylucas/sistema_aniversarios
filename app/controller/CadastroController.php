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
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if (!$email) {
            echo json_encode(['erro' => true, 'mensagem' => 'Digite um email valido Ex: teste@gmail.com.']);
            exit;
        }

        if ($nome && $email && $senha) {
            if ($this->usuarioDAO->buscarPorEmail($email) == false) {
                $usuario = new Usuario();
                $usuario->setNome($nome);
                $usuario->setEmail($email);
                $usuario->setSenha($senha);
                $cadastro = $this->usuarioDAO->adicionar($usuario);

                if ($cadastro) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'mensagem' => 'Cadastro realizado com sucesso! Faça login para continuar.']);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['erro' => true, 'mensagem' => 'Email já cadastrado. Por favor, utilize outro email.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['erro' => true, 'mensagem' => 'Dados inválidos. Por favor, preencha todos os campos corretamente']);
            exit;
        }
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
    $controller = new CadastroController();
    $controller->cadastrarUsuario();
}
