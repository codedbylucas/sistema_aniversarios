<?php

class Usuario
{
    private $id;
    private $nome;
    private $senha;
    private $email;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = trim(ucwords($nome));
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha($senha)
    {
        // Verifica se a senha já está hasheada
        if (!password_get_info($senha)['algo']) {
            $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $this->senha = $senha; // Senha já está hasheada
        }
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
}


interface IUsuarioDAO
{
    public function adicionar(Usuario $usuario);
    public function atualizar(Usuario $usuario);
    public function deletar($id);
    public function buscarPorId($id);
    public function buscarPorEmail($nome);
}
