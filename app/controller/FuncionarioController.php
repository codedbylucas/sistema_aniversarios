<?php

require_once __DIR__ . '/../dao/FuncionarioDAO.php';
require_once __DIR__ . '/../model/Funcionario.php';
require_once __DIR__ . '/../config/DBConnection.php';

class FuncionarioController
{
    private $funcionarioDAO;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->funcionarioDAO = new FuncionarioDAO($pdo);
    }

    public function adicionarFuncionario()
    {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
        $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
        $data = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if ($nome && $cargo && $data && $whatsapp) {
            $funcionario = new Funcionario();
            $funcionario->setNome($nome);
            $funcionario->setCargo($cargo);
            $funcionario->setWhatsapp($whatsapp);
            $funcionario->setDataNascimento($data);
            $this->funcionarioDAO->adicionar($funcionario);

            header("Location: ../view/funcionarios.php?mensagem=Funcionário cadastrado com sucesso!");
            exit;
        } else {
            header("Location: ../view/funcionarios.php?mensagem=Erro ao cadastrar funcionário. Verifique os dados e tente novamente.");
            exit;
        }
    }

    public function deletar($id)
    {
        $id = intval($id);

        $this->funcionarioDAO->deletar($id);
        header("Location: ../view/funcionarios.php?mensagem=Funcionário deletado com sucesso!");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new FuncionarioController();
    $controller->adicionarFuncionario();
}

if (!empty($_GET['id'])) {
    $controller = new FuncionarioController();
    $controller->deletar($_GET['id']);
} else {
    header("Location: ../view/funcionarios.php");
    exit;
}
