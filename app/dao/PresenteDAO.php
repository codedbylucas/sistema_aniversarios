<?php

require_once __DIR__ . '/../model/Presente.php';
require_once __DIR__ . '/../model/Participantes.php';
require_once __DIR__ . '/../config/DBConnection.php';



class PresenteDAO implements IPresenteDAO
{

    private $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }


    public function cadastrarPresente(Presente $presente)
    {
        $sql = $this->pdo->prepare("INSERT INTO presentes (descricao, valor_total) VALUES (:descricao, :valor_total)");
        $sql->bindValue(':descricao', $presente->getDescricao());
        $sql->bindValue(':valor_total', $presente->getValorTotal());
        $sql->execute();
        return $this->pdo->lastInsertId();
    }
    public function vincularFuncionarios($presenteId, $funcionarios, $valor_total)
    {
        $valorPorFuncionario = $valor_total / count($funcionarios);
        foreach ($funcionarios as $funcionarioId) {
            $sql = $this->pdo->prepare("INSERT INTO participacoes_presentes (id_presente, id_funcionario, valor_contribuicao, status_pagamento)
                VALUES (:id_presente, :id_funcionario, :valor_contribuicao, 'pendente')");
            $sql->bindValue(':id_presente', $presenteId);
            $sql->bindValue(':id_funcionario', $funcionarioId);
            $sql->bindValue(':valor_contribuicao', $valorPorFuncionario);
            $sql->execute();
        }
        return true;
    }

    public function buscarDetalhes($id)
    {
        $dadosPresentes = [];
        $sqlPresente = "SELECT id, descricao, valor_total, status FROM presentes WHERE id = :id";
        $stmt = $this->pdo->prepare($sqlPresente);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $presente = $stmt->fetch(PDO::FETCH_ASSOC);
        $dadosPresentes[] = $presente;

        $sqlParticipantes = $this->pdo->prepare(
            "SELECT 
            pp.id as id_relacao,
            pp.status_pagamento,
            f.nome,
            pp.valor_contribuicao
        FROM participacoes_presentes pp
        INNER JOIN funcionarios f ON f.id = pp.id_funcionario
        WHERE pp.id_presente = :id"
        );
        $sqlParticipantes->bindValue(':id', $id);
        $sqlParticipantes->execute();
        $participantes = $sqlParticipantes->fetchAll(PDO::FETCH_ASSOC);

        $dadosParticipantes = [];
        foreach ($participantes as $p) {
            $participantes = new Participantes();
            $participantes->setIdRelacao($p['id_relacao']);
            $participantes->setNome($p['nome']);
            $participantes->setStatusPagamento($p['status_pagamento']);
            $participantes->setValorContribuicao($p['valor_contribuicao']);

            $dadosParticipantes[] = $participantes->returnArray();
        }

        return [
            'presente' => $dadosPresentes,
            'participantes' => $dadosParticipantes
        ];
    }

    public function buscarTodos()
    {
        $sql = $this->pdo->query("SELECT * FROM presentes ORDER BY status DESC");
        if ($sql->rowCount() > 0) {
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $presentes = [];
            foreach ($result as $row) {
                $presente = new Presente();
                $presente->setId($row['id']);
                $presente->setDescricao($row['descricao']);
                $presente->setValorTotal($row['valor_total']);
                $presente->setStatus($row['status']);
                $presente->setDataCadastro($row['data_cadastro']);
                $presentes[] = $presente;
            }
            return $presentes;
        } else {
            return false;
        }
    }

    public function marcarComoPago($id_relacao)
    {
        $sql = $this->pdo->prepare("UPDATE participacoes_presentes SET status_pagamento = 'pago' WHERE id = :id_relacao");
        $sql->bindValue(':id_relacao', $id_relacao);
        $sql->execute();
        if ($sql->rowCount() == 0) {
            return false;
        }
        $this->verificarStatusParticipante($id_relacao);

        return true;
    }

    public function verificarStatusParticipante($id_relacao)
    {

        $sql = $this->pdo->prepare("SELECT id_presente FROM participacoes_presentes WHERE id = :id_relacao");
        $sql->bindValue(':id_relacao', $id_relacao);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        $idPresente = $result['id_presente'];

        $sqlVerifica = $this->pdo->prepare("SELECT COUNT(*) as total_pendentes FROM participacoes_presentes 
            WHERE id_presente = :id_presente AND status_pagamento = 'pendente'");
        $sqlVerifica->bindValue(':id_presente', $idPresente);
        $sqlVerifica->execute();
        $resultado = $sqlVerifica->fetch(PDO::FETCH_ASSOC);

        if ($resultado['total_pendentes'] == 0) {
            $sqlAtualiza = $this->pdo->prepare("UPDATE presentes SET status = 'pago' WHERE id = :id_presente");
            $sqlAtualiza->bindValue(':id_presente', $idPresente);
            $sqlAtualiza->execute();
        } else {
            $sql = "UPDATE presentes SET status = 'pendente' WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $idPresente);
            $stmt->execute();
        }
    }

    public function deletarParticipacao($id_relacao)
    {
        $sql = $this->pdo->prepare("DELETE FROM participacoes_presentes WHERE id = :id_relacao");
        $sql->bindValue(':id_relacao', $id_relacao);
        $sql->execute();

        return true;
    }

    public function buscarPorIdPresente($id_relacao)
    {
        $sql = $this->pdo->prepare("SELECT id_presente FROM participacoes_presentes WHERE id = :id_relacao");
        $sql->bindValue(':id_relacao', $id_relacao);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result['id_presente'];
    }
    public function deletarPresente($id_presente)
    {
        $sql = $this->pdo->prepare(
            "SELECT 
                p.id, 
                COUNT(pp.id_funcionario) as contagem_funcionario, 
                pp.id_presente
            FROM presentes p
            INNER JOIN participacoes_presentes pp ON pp.id_presente = p.id
            WHERE p.id = :id
        "
        );
        $sql->bindValue(':id', $id_presente);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if ($result['contagem_funcionario'] > 0) {
            return false;
        } else {
            $sql = $this->pdo->prepare("DELETE FROM presentes WHERE id = :id");
            $sql->bindValue(':id', $id_presente);
            $sql->execute();

            return true;
        }
    }

    public function atualizar(Presente $presente) {}

    public function redistribuirValores($id_presente)
    {
        $sqlValor = $this->pdo->prepare("SELECT valor_total FROM presentes WHERE id = :id");
        $sqlValor->bindValue(':id', $id_presente);
        $sqlValor->execute();
        $presente = $sqlValor->fetch(PDO::FETCH_ASSOC);

        if (!$presente) {
            return false;
        }

        $valor_total = $presente['valor_total'];

        // Verifica quantos participantes ainda restam
        $sqlQtd = $this->pdo->prepare("SELECT COUNT(*) as total FROM participacoes_presentes WHERE id_presente = :id");
        $sqlQtd->bindValue(':id', $id_presente);
        $sqlQtd->execute();
        $qtd = $sqlQtd->fetch(PDO::FETCH_ASSOC)['total'];

        if ($qtd > 0) {
            // Divide novamente o valor
            $novoValor = number_format($valor_total / $qtd, 2, '.', '');

            $stmtUpdate = $this->pdo->prepare("UPDATE participacoes_presentes SET valor_contribuicao = :valor WHERE id_presente = :id");
            $stmtUpdate->bindValue(':valor', $novoValor);
            $stmtUpdate->bindValue(':id', $id_presente);
            $stmtUpdate->execute();
        }

        return true;
    }
}
