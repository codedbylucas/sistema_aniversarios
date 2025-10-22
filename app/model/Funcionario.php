<?php

class Funcionario
{
    private $id;
    private $nome;
    private $data_nascimento;
    private $cargo;
    private $whatsapp;
    private $status;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = trim(ucwords($nome)); }

    public function getDataNascimento() { return $this->data_nascimento; }
    public function setDataNascimento($data_nascimento) { $this->data_nascimento = $data_nascimento; }

    public function getCargo() { return $this->cargo; }
    public function setCargo($cargo) { $this->cargo = $cargo; }

    public function getWhatsapp() { return $this->whatsapp; }
    public function setWhatsapp($whatsapp) { $this->whatsapp = $whatsapp; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }
}

interface IFuncionarioDAO {
    public function adicionar(Funcionario $funcionario);
    public function atualizar(Funcionario $funcionario);
    public function deletar($id);
    public function buscarPorId($id);
    public function buscarTodos();
}