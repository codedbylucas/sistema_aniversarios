<?php 
session_start();
require_once __DIR__ . '/../controller/AutenticacaoController.php';

if(AutenticacaoController::validarAcesso() === false){
    AutenticacaoController::encerrarSessao();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php';?>

    <!-- Conteúdo principal -->
    <main class="flex-1 p-10">

        <h2 class="text-3xl font-bold text-blue-700 mb-8">Bem-vindo, <?= $_SESSION['nome']; ?></h2>

        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold text-blue-600 mb-2">Aniversariantes do Mês</h3>
                <p class="text-4xl font-bold text-blue-700">3</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold text-blue-600 mb-2">Funcionários Cadastrados</h3>
                <p class="text-4xl font-bold text-blue-700">12</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                <h3 class="text-lg font-semibold text-blue-600 mb-2">Presentes Pagos</h3>
                <p class="text-4xl font-bold text-blue-700">8</p>
            </div>
        </div>

        <!-- Seção de aniversariantes -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-blue-600 mb-4">Aniversariantes deste mês</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-3 px-4 text-left rounded-tl-lg">Nome</th>
                        <th class="py-3 px-4 text-left">Data</th>
                        <th class="py-3 px-4 text-left">Cargo</th>
                        <th class="py-3 px-4 text-left rounded-tr-lg">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-blue-50">
                        <td class="py-3 px-4">Ana Souza</td>
                        <td class="py-3 px-4">12/10</td>
                        <td class="py-3 px-4">Financeiro</td>
                        <td class="py-3 px-4">
                            <button onclick="Swal.fire('Parabéns!', 'Lembrete enviado para o grupo!', 'success')"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg text-sm">
                                Enviar Lembrete
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-blue-50">
                        <td class="py-3 px-4">Carlos Lima</td>
                        <td class="py-3 px-4">21/10</td>
                        <td class="py-3 px-4">Logística</td>
                        <td class="py-3 px-4">
                            <button onclick="Swal.fire('Parabéns!', 'Lembrete enviado para o grupo!', 'success')"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg text-sm">
                                Enviar Lembrete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</body>

</html>