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

    public function listarTodos()
    {
        $funcionario = $this->funcionarioDAO->buscarTodos();

        if ($funcionario) {
            $dados = array_map(function ($f) {
                return $f->returnArray();
            }, $funcionario);

            header('Content-Type: application/json');
            echo json_encode($dados);
            exit;
        } else {
            echo json_encode(['erro' => 'Funcionário não encontrado']);
            exit;
        }
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

            header('Content-Type: application/json');
            echo json_encode(['sucesso' => true, 'mensagem' => 'Funcionario cadastrado com sucesso!']);
            exit;
        } else {
            echo json_encode(['erro' => 'Erro ao cadastrar Funcionario!']);
            exit;
        }
    }

    public function deletar($id)
    {
        $id = intval($id);

        if ($id) {
            $deletar = $this->funcionarioDAO->deletar($id);
            
            if ($deletar) {
                header('Content-Type: application/json');
                echo json_encode(['sucesso' => true, 'mensagem' => 'Funcionário deletado com sucesso!']);
            } else {
                echo json_encode(['erro' => true, 'mensagem' => 'Falha ao deletar usuario']);
            }
        } else {
            echo json_encode(['erro' => 'Erro ao deletar funcionario!']);
            exit;
        }
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

    public function atualizarFuncionario()
    {
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
        $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
        $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);

        $id = intval($id);

        if ($id && $nome && $cargo && $whatsapp && $data_nascimento) {

            $funcionario = new Funcionario();
            $funcionario->setId((int)$id);
            $funcionario->setNome($nome);
            $funcionario->setCargo($cargo);
            $funcionario->setWhatsapp($whatsapp);
            $funcionario->setDataNascimento($data_nascimento);

            $atualizado = $this->funcionarioDAO->atualizar($funcionario);
            if ($atualizado) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Funcionário atualizado com sucesso!']);
            } else {
                echo json_encode(['erro' => true, 'mensagem' => 'Erro ao atualizar funcionário.']);
            }
        } else {
            echo json_encode(['erro' => true, 'mensagem' => 'Dados inválidos.']);
        }
        exit;
    }
}

//CADASTRO 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST) && isset($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
    $controller = new FuncionarioController();
    $controller->adicionarFuncionario();
}

//DELETAR
if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && !empty($_GET['id'])) {
    $controller = new FuncionarioController();
    $controller->deletar($_GET['id']);
}

//BUSCAR PARA EDIÇÃO
if (isset($_GET['acao']) && $_GET['acao'] === 'editar' && !empty($_GET['id'])) {
    $funcionario = new FuncionarioController();
    $funcionario->buscarFuncionario($_GET['id']);
}

//EDITANDO
if (isset($_GET['acao']) && $_GET['acao'] === 'atualizar') {
    $controller = new FuncionarioController();
    $controller->atualizarFuncionario();
}

//LISTAR
if (isset($_GET['acao']) && $_GET['acao'] === 'listar') {
    $controller = new FuncionarioController();
    $controller->listarTodos();
}

// header("Location: ../view/funcionarios.php");
// exit;
