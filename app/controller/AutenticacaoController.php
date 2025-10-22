<?php

class AutenticacaoController
{
    public static function validarAcesso()
    {
        if (empty($_SESSION['usuario_id'])) {
            header("Location: ../view/login.php");
            exit;
        }

        return true;
    }

    public static function encerrarSessao()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit;
    }

}

if (isset($_GET['acao']) && $_GET['acao'] === 'sair') {
    AutenticacaoController::encerrarSessao();
}
