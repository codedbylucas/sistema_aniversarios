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

    public function buscarFuncionario($id)
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = intval($id);
        
        if ($id) {
            
            $funcionario = $this->funcionarioDAO->buscarPorId($id);
            header('Content-Type: application/json');

            if ($funcionario) {
                echo json_encode($funcionario->returnArray());
            } else {
                echo json_encode(['erro' => 'Funcionário não encontrado']);
            }
        } else {
            echo json_encode(['erro' => 'ID não informado']);
        }

        exit;
    }

    public function editarFuncionario()
    {
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
        $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
        $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        //VERIFICAR SE ESTA CHEGANDO, CRIAR UM NOVO OBJETO FUNCIONARIO E CHAMAR O METODO ATUALIZAR DO DAO...
    }

}

//CADASTRO 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
    $controller = new FuncionarioController();
    $controller->adicionarFuncionario();
}

//DELETAR
if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && !empty($_GET['id'])) {
    $controller = new FuncionarioController();
    $controller->deletar($_GET['id']);
    exit;
}

//BUSCAR PARA EDIÇÃO
if (isset($_GET['acao']) && $_GET['acao'] === 'editar' && !empty($_GET['id'])) {
    $funcionario = new FuncionarioController();
    $funcionario->buscarFuncionario($_GET['id']);
}

//EDITANDO
if(isset($_SERVER['REQUEST_METHOD']) === 'POST' && isset($_GET['acao']) && $_GET['acao'] === 'editar') {
    $controller = new FuncionarioController();
    $controller->editarFuncionario();
}

header("Location: ../view/funcionarios.php");
exit;
