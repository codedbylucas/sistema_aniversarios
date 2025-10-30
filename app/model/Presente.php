<?php

class Presente{
    private $id;
    private $descricao;
    private $valor_total;
    private $funcionarios = [];
    private $status;

    public function getId() { return $this->id; }
    public function getDescricao() { return $this->descricao; }
    public function getValorTotal() { return $this->valor_total; }
    public function getFuncionarios() { return $this->funcionarios; }
    public function getStatus() { return $this->status; }

    public function setId($id) { $this->id = $id; }
    public function setDescricao($descricao) { $this->descricao = ucwords($descricao); }
    public function setValorTotal($valor_total) { $this->valor_total = $valor_total; }
    public function setFuncionarios($funcionarios) { $this->funcionarios = $funcionarios; }
    public function setStatus($status) { $this->status = $status; }


    public function returnArray() {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'valor_total' => $this->valor_total,
            'funcionarios' => $this->funcionarios, 
            'status' => $this->status
        ];
    }

}

interface IPresenteDAO {
    public function cadastrarPresente(Presente $presente);
    public function vincularFuncionarios($presenteId, $funcionarios, $valor_total);
    public function atualizar(Presente $presente);
    public function deletarPresente($id_presente);
    public function buscarDetalhes($id);
    public function buscarTodos();
    public function marcarComoPago($id_relacao);
    public function verificarStatusParticipante($id_relacao);
    public function deletarParticipacao($id_relacao);
    public function buscarPorIdPresente($id_presente);
}