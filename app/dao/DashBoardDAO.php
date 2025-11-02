<?php


class DashBoardDAO {

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarFuncionarios() {
        $sql = $this->pdo->query('SELECT * FROM funcionarios');
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function presentesPagos() {
        $sql = $this->pdo->query("SELECT COUNT(*) as quantidade FROM presentes WHERE status = 'pago' ");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if($result['quantidade'] > 0) {
            return $result['quantidade'];
        }else {
            return 0;
        }
    }

    public function aniversariosMes() {
        $sql = $this->pdo->query(
        "SELECT * FROM funcionarios WHERE MONTH(data_nascimento) = MONTH(CURDATE())");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}