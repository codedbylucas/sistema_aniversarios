<?php

require_once __DIR__ . '/../model/Presente.php';
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
    public function atualizar(Presente $presente) {}
    public function deletar($id) {}
    public function buscarPorId($id) {}
    
    public function buscarTodos()
    {
        $sql = $this->pdo->query("SELECT * FROM presentes");
        if ($sql->rowCount() > 0) {
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $presentes = [];
            foreach ($result as $row) {
                $presente = new Presente();
                $presente->setId($row['id']);
                $presente->setDescricao($row['descricao']);
                $presente->setValorTotal($row['valor_total']);
                $presentes[] = $presente;
            }
            return $presentes;
        } else {
            return false;
        }
    }
}
