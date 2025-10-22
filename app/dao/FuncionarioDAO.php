<?php

require_once '../model/Funcionario.php';

class FuncionarioDAO implements IFuncionarioDAO
{

    private $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    public function adicionar(Funcionario $funcionario)
    {
        $sql = $this->pdo->prepare("INSERT INTO funcionarios (nome, cargo, whatsapp, data_nascimento) VALUES (:nome, :cargo, :whatsapp, :data_nascimento)");
        $sql->bindValue(':nome', $funcionario->getNome());
        $sql->bindValue(':cargo', $funcionario->getCargo());
        $sql->bindValue(':whatsapp', $funcionario->getWhatsapp());
        $sql->bindValue(':data_nascimento', $funcionario->getDataNascimento());
        $sql->execute();
    }
    public function atualizar(Funcionario $funcionario) {}

    public function deletar($id)
    {
        $sql = $this->pdo->prepare('DELETE FROM funcionarios WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    public function buscarPorId($id)
    {
        $sql = $this->pdo->prepare('SELECT * FROM funcionarios WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $funcionario = new Funcionario();
            $funcionario->setId($data['id']);
            $funcionario->setNome($data['nome']);
            $funcionario->setCargo($data['cargo']);
            $funcionario->setWhatsapp($data['whatsapp']);
            $funcionario->setDataNascimento($data['data_nascimento']);

            return $funcionario;
        }
        return null;    
        
    }

    public function buscarTodos()
    {
        $funcionarios = [];
        $sql = $this->pdo->query("SELECT * FROM funcionarios");
        if ($sql->rowCount() > 0) {
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dados as $item) {
                $funcionario = new Funcionario();
                $funcionario->setId($item['id']);
                $funcionario->setNome($item['nome']);
                $funcionario->setCargo($item['cargo']);
                $funcionario->setWhatsapp($item['whatsapp']);
                $funcionario->setDataNascimento($item['data_nascimento']);
                $funcionarios[] = $funcionario;
            }
        }
        return $funcionarios;
    }
}
