<?php

class DBConnection
{
    private $db_host = 'localhost';
    private $db_name = 'sistema_aniversarios';
    private $db_user = 'root';
    private $db_password = '';
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->pdo;
        } catch (PDOException $e) {
            die("Falha na conexao: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
