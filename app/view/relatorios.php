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
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 ml-64 p-10 overflow-y-auto">
        <h1 class="text-3xl font-semibold text-blue-800 mb-6">📊 Relatórios Gerais</h1>

        <!-- Filtros -->
        <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Filtros</h2>
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                    <select class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option value="">Selecione...</option>
                        <option>Janeiro</option>
                        <option>Fevereiro</option>
                        <option>Março</option>
                        <option>Abril</option>
                        <option>Maio</option>
                        <option>Junho</option>
                        <option>Julho</option>
                        <option>Agosto</option>
                        <option>Setembro</option>
                        <option>Outubro</option>
                        <option>Novembro</option>
                        <option>Dezembro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option value="">Todos</option>
                        <option>Pago</option>
                        <option>Pendente</option>
                    </select>
                </div>

                <div class="flex items-end justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition">Gerar Relatório</button>
                </div>
            </form>
        </div>

        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-sm mb-1">Aniversariantes no mês</p>
                <h3 class="text-2xl font-semibold text-blue-700">4</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-sm mb-1">Presentes cadastrados</p>
                <h3 class="text-2xl font-semibold text-blue-700">12</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-sm mb-1">Presentes pagos</p>
                <h3 class="text-2xl font-semibold text-green-600">8</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500 text-sm mb-1">Pendentes</p>
                <h3 class="text-2xl font-semibold text-red-600">4</h3>
            </div>
        </div>

        <!-- Tabela -->
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Detalhamento</h2>
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-blue-50 text-blue-800">
                        <th class="py-2 px-3 text-left">Funcionário</th>
                        <th class="py-2 px-3 text-left">Presente</th>
                        <th class="py-2 px-3 text-left">Valor</th>
                        <th class="py-2 px-3 text-left">Data</th>
                        <th class="py-2 px-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-2 px-3">Lucas</td>
                        <td class="py-2 px-3">Caixa de bombons</td>
                        <td class="py-2 px-3">R$ 35,00</td>
                        <td class="py-2 px-3">12/10/2025</td>
                        <td class="py-2 px-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Pago</span></td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2 px-3">Ana</td>
                        <td class="py-2 px-3">Perfume</td>
                        <td class="py-2 px-3">R$ 90,00</td>
                        <td class="py-2 px-3">17/10/2025</td>
                        <td class="py-2 px-3"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</body>

</html>