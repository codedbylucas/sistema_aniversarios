<?php

class Presente{
    private $id;
    private $descricao;
    private $valor_total;
    private $funcionarios = [];

    public function getId() { return $this->id; }
    public function getDescricao() { return $this->descricao; }
    public function getValorTotal() { return $this->valor_total; }
    public function getFuncionarios() { return $this->funcionarios; }

    public function setId($id) { $this->id = $id; }
    public function setDescricao($descricao) { $this->descricao = ucwords($descricao); }
    public function setValorTotal($valor_total) { $this->valor_total = $valor_total; }
    public function setFuncionarios($funcionarios) { $this->funcionarios = $funcionarios; }

    public function returnArray() {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'valor_total' => $this->valor_total,
            'funcionarios' => $this->funcionarios 
        ];
    }

}

interface IPresenteDAO {
    public function cadastrarPresente(Presente $presente);
    public function vincularFuncionarios($presenteId, $funcionarios, $valor_total);
    public function atualizar(Presente $presente);
    public function deletar($id);
    public function buscarPorId($id);
    public function buscarTodos();
}