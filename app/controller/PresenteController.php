<?php

require_once __DIR__ . '/../dao/PresenteDAO.php';
require_once __DIR__ . '/../model/Presente.php';
require_once __DIR__ . '/../config/DBConnection.php';
require_once __DIR__ . '/../dao/FuncionarioDAO.php';

class PresenteController
{

    private $presenteDAO;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->presenteDAO = new PresenteDAO($pdo);
    }

    public function listarParticipantes()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $funcionarioDao = new FuncionarioDAO($pdo);
        $funcionario = $funcionarioDao->buscarTodos();

        if ($funcionario) {
            $dados = array_map(function ($f) {
                return $f->returnArray();
            }, $funcionario);
            echo json_encode([$dados]);
            exit;
        } else {
            echo json_encode(['erro' => 'Erro ao buscar participantes!']);
            exit;
        }
    }

    public function cadastrarPresente()
    {

        $descricao = $_POST['descricao'] ?? '';
        $valor_total = $_POST['valor'] ?? '';
        $funcionarios = json_decode($_POST['funcionarios'], true);

        if (empty($descricao) || empty($valor_total) || empty($funcionarios)) {
            echo json_encode(['erro' => 'Todos os campos são obrigatórios!']);
            exit;
        }

        $novoPresente = new Presente();
        $novoPresente->setDescricao($descricao);
        $novoPresente->setValorTotal($valor_total);
        $novoPresente->setFuncionarios($funcionarios);
        $presenteDAO = $this->presenteDAO->cadastrarPresente($novoPresente);

        $this->presenteDAO->vincularFuncionarios($presenteDAO, $funcionarios, $valor_total);

        if ($presenteDAO) {
            header('Content-Type: application/json');
            echo json_encode(['success' => 'Presente cadastrado com sucesso!']);
            exit;
        } else {
            echo json_encode(['erro' => 'Erro ao cadastrar presente!']);
            exit;
        }
    }

    public function listarPresentes() {
        $presentes = $this->presenteDAO->buscarTodos();

        if ($presentes) {
            $dados = array_map(function ($p) {
                return $p->returnArray();
            }, $presentes);
            echo json_encode($dados);
        } else {
            echo json_encode(['erro' => 'Erro ao buscar presentes!']);
            exit;
        }
    }
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'participantes') {
    $presenteController = new PresenteController();
    $presenteController->listarParticipantes();
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
    $presenteController = new PresenteController();
    $presenteController->cadastrarPresente();
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'listar') {
    $presenteController = new PresenteController();
    $presenteController->listarPresentes();
}
