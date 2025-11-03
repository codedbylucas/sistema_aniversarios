<?php
session_start();
require_once __DIR__ . '/../controller/AutenticacaoController.php';

if (AutenticacaoController::validarAcesso() === false) {
    AutenticacaoController::encerrarSessao();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/dashboard.js"></script>
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 ml-64 p-10 overflow-y-auto">

        <h2 class="text-3xl font-bold text-blue-700 mb-8">Bem-vindo, <?= $_SESSION['nome']; ?></h2>

        <!-- Cards de resumo -->
        <div id="card-relatorio" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Conteúdo dos cards gerado pelo JS -->
        </div>

        <!-- Seção de aniversariantes -->
        <div id="lista-aniversario" class="bg-white rounded-3xl shadow-2xl p-8">
            <h3 class="text-2xl font-bold text-blue-600 mb-6">Aniversariantes deste mês</h3>
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700">
                        <th class="py-3 px-4 rounded-tl-lg">Nome</th>
                        <th class="py-3 px-4">Data</th>
                        <th class="py-3 px-4">Cargo</th>
                        <th class="py-3 px-4 rounded-tr-lg">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-aniversario" class="divide-y divide-gray-200">
                    <!-- Linhas geradas pelo JS -->
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
