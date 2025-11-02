<?php

require_once __DIR__ . '/../dao/DashBoardDAO.php';
require_once __DIR__ . '/../config/DBConnection.php';


class DashBoardController
{

    private $dashboardDao;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $pdo = $dbConnection->getConnection();
        $this->dashboardDao = new DashBoardDAO($pdo);
    }

    public function relatorioDash()
    {
        $getFuncionarios = $this->dashboardDao->buscarFuncionarios();
        $presentesPagos = $this->dashboardDao->presentesPagos();
        $aniversariosMes = $this->dashboardDao->aniversariosMes();

        header('Content-Type: application/json');
        echo json_encode([['funcionarios' => count($getFuncionarios),
            'presentes' => $presentesPagos,
            'aniversariantes_mes' => $aniversariosMes]]);

    }
}

//LISTAR
if (isset($_GET['acao']) && $_GET['acao'] === 'relatorioDash') {
    $controller = new DashBoardController();
    $controller->relatorioDash();
}
