<?php


class RelatorioGeralDAO
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarFiltro($mes = null, $status = null)
    {

        $sql =
            "SELECT
                p.descricao,
                p.valor_total,
                p.data_cadastro,
                p.status,
                GROUP_CONCAT(f.nome SEPARATOR ', ') AS participantes
            FROM presentes p
            INNER JOIN participacoes_presentes pp ON pp.id_presente = p.id
            INNER JOIN funcionarios f ON f.id = pp.id_funcionario
            WHERE 1 = 1
        ";

        if (!empty($mes)) {
            $sql .= " AND MONTH(p.data_cadastro) = :mes";
        }

        if (!empty($status) && $status !== 'todos') {
            $sql .= " AND p.status = :status";
        }

        $sql .= " GROUP BY p.descricao, p.valor_total, p.data_cadastro, p.status";
        $sql .= " ORDER BY p.status ASC, p.data_cadastro DESC"; // primeiro pelo status, depois pela data

        $stmt = $this->pdo->prepare($sql);

        if (!empty($mes)) {
            $stmt->bindValue(':mes', $mes, PDO::PARAM_INT);
        }

        if (!empty($status) && $status !== 'todos') {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }


        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna array vazio se nada encontrado
    }

    public function buscarTodosPresentes() {
        $sql = $this->pdo->prepare(
            "SELECT
                p.descricao,
                p.valor_total,
                p.data_cadastro,
                p.status,
                GROUP_CONCAT(f.nome SEPARATOR ', ') AS participantes
            FROM presentes p
            INNER JOIN participacoes_presentes pp ON pp.id_presente = p.id
            INNER JOIN funcionarios f ON f.id = pp.id_funcionario
            WHERE 1 = 1
            GROUP BY p.descricao, p.valor_total, p.data_cadastro, p.status
            ORDER BY p.status DESC
        ");
        $sql->execute();
        if($sql->rowCount() > 0) {
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result; 
        }else {
            return [];
        }
    }
}
