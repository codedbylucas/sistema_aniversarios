<?php

require_once __DIR__ . '/../dao/RelatorioGeralDAO.php';
require_once __DIR__ . '/../config/DBConnection.php';


class RelatorioGeralController
{

    private $relatorioDAO;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->relatorioDAO = new RelatorioGeralDAO($pdo);
    }

    public function relatorioGeral()
    {
        $mes = $_GET['mes'] ?? null;
        $status = $_GET['status'] ?? null;

        if ($mes === '' || strtolower($mes) === 'todos') {
            $mes = null;
        } else {
            $mes = intval($mes);
        }

        $dados = $this->relatorioDAO->buscarFiltro($mes, $status);

        $totalAniversariantes = count(array_unique(array_column($dados, 'funcionario')));
        $totalPresentes = count($dados);
        $totalPagos = count(array_filter($dados, fn($item) => $item['status'] === 'pago'));
        $totalPendentes = $totalPresentes - $totalPagos;

        header('Content-Type: application/json');

        echo json_encode([
            'dados' => $dados,
            'totalAniversarios' => $totalAniversariantes,
            'totalPagos' => $totalPagos,
            'totalPresentes' => $totalPresentes,
            'totalPendentes' => $totalPendentes
        ]);
    }

    public function buscarTodos()
    {
        $dados = $this->relatorioDAO->buscarTodosPresentes();
        $totalPresentes = count($dados);
        $totalPagos = count(array_filter($dados, fn($item) => $item['status'] === 'pago'));
        $totalPendentes = $totalPresentes - $totalPagos;

        if ($dados) {
            header('Content-Type: application/json');
            echo json_encode([
                'dados' => $dados,
                'totalPagos' => $totalPagos,
                'totalPresentes' => $totalPresentes,
                'totalPendentes' => $totalPendentes
            ]);
            exit;
        } else {
            echo json_encode(['erro' => true]);
            exit;
        }
    }
}

if (!empty($_GET['mes']) || !empty($_GET['status'])) {
    $controller = new RelatorioGeralController();
    $controller->relatorioGeral();
}

if (!empty($_GET['acao']) && $_GET['acao'] === 'listar') {
    $controlleer = new RelatorioGeralController();
    $controlleer->buscarTodos();
}
