<?php

class Participantes {
    private $id_relacao;
    private $nome;
    private $status_pagamento;
    private $valor_contribuicao;

    public function getIdRelacao() {
        return $this->id_relacao;
    }
    public function setIdRelacao($id_relacao) {
        $this->id_relacao = $id_relacao;
    }
    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = ucwords($nome);
    }
    public function getStatusPagamento() {
        return $this->status_pagamento;
    }
    public function setStatusPagamento($status_pagamento) {
        $this->status_pagamento = $status_pagamento;
    }
    public function getValorContribuicao() {
        return $this->valor_contribuicao;
    }
    public function setValorContribuicao($valor_contribuicao) {
        $this->valor_contribuicao = $valor_contribuicao;
    }

    public function returnArray() {
        return [
            'id_relacao' => $this->id_relacao,
            'nome' => $this->nome,
            'status_pagamento' => $this->status_pagamento,
            'valor_contribuicao' => $this->valor_contribuicao
        ];
    }
}