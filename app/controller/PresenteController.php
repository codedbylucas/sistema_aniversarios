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
            echo json_encode(['erro' => 'Preencha todos os campos!']);
            exit;
        }
    }

    public function listarPresentes()
    {
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

    public function detalhesPresente($id)
    {

        if ($id) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $detalhe = $this->presenteDAO->buscarDetalhes($id);

            if ($detalhe) {
                header('Content-Type: application/json');
                echo json_encode($detalhe);
            } else {
                echo json_encode(['erro' => 'Erro ao buscar detalhes do presente!']);
                exit;
            }
        }
    }

    public function marcarComoPago($id_relacao)
    {

        $id_relacao = filter_var($id_relacao, FILTER_SANITIZE_NUMBER_INT);

        if ($id_relacao) {
            $id_presente = $this->presenteDAO->buscarPorIdPresente($id_relacao);
            $pago = $this->presenteDAO->marcarComoPago($id_relacao);

            if ($pago) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $pago,
                    'id_presente' => $id_presente
                ]);
            } else {
                echo json_encode(['erro' => 'Erro ao marcar pagamento como pago!']);
                exit;
            }
        }
    }

    public function deletarParticipacao($id_relacao)
    {
        $id_relacao = filter_var($id_relacao, FILTER_SANITIZE_NUMBER_INT);

        if ($id_relacao) {

            $id_presente = $this->presenteDAO->buscarPorIdPresente($id_relacao);
            $deletar = $this->presenteDAO->deletarParticipacao($id_relacao);

            if ($deletar) {
                $this->presenteDAO->redistribuirValores($id_presente);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $deletar,
                    'id_presente' => $id_presente
                ]);
            } else {
                echo json_encode(['erro' => 'Erro ao deletar participação!']);
                exit;
            }
        }
    }

    public function deletarPresente($id_presente)
    {
        $id_presente = filter_var($id_presente, FILTER_SANITIZE_NUMBER_INT);

        if ($id_presente) {
            $deletar = $this->presenteDAO->deletarPresente($id_presente);

            if ($deletar) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $deletar
                ]);
            } else {
                echo json_encode(['erro' => $deletar]);
                exit;
            }
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

if (!empty($_GET['acao']) && $_GET['acao'] === 'detalhes') {
    $presenteController = new PresenteController();
    $presenteController->detalhesPresente($_GET['id']);
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'marcarPago') {
    $presenteController = new PresenteController();
    $presenteController->marcarComoPago($_GET['id_relacao']);
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'deletarParticipacao') {
    $presenteController = new PresenteController();
    $presenteController->deletarParticipacao($_GET['id_relacao']);
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'deletarPresente') {
    $presenteController = new PresenteController();
    $presenteController->deletarPresente($_GET['id']);
}
