<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
require_once __DIR__ . '/../controller/AutenticacaoController.php';

if (AutenticacaoController::validarAcesso() === false) {
    AutenticacaoController::encerrarSessao();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentes - Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/relatorioGeral.js"></script>
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 ml-64 p-10 overflow-y-auto">
        <h1 class="text-3xl font-semibold text-blue-800 mb-6">Relatórios Gerais</h1>

        <!-- Filtros -->
        <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Filtros</h2>
            <form id="form-filtro" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                    <select id="mes" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option >Selecione...</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option value="todos">Todos</option>
                        <option value="pago">Pago</option>
                        <option value="pendente">Pendente</option>
                    </select>
                </div>

                <div class="flex items-end justify-end">
                    <input
                        onclick="relatorioGeral()"
                        value="Filtrar"
                        type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition" />
                </div>
            </form>
        </div>

        <div id="card" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        </div>

        <!-- Tabela -->
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Detalhamento</h2>
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-blue-50 text-blue-800">
                        <th class="py-2 px-3 text-left">Participantes</th>
                        <th class="py-2 px-3 text-left">Presente</th>
                        <th class="py-2 px-3 text-left">Valor</th>
                        <th class="py-2 px-3 text-left">Data</th>
                        <th class="py-2 px-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>

    </main>
</body>

</html>