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

<body class="bg-slate-100 min-h-screen flex">

    <?php require '../header/header.php'; ?>


    <!-- Conteúdo principal -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-semibold text-blue-800 mb-6">🎁 Controle de Presentes</h1>

        <!-- Formulário de cadastro -->
        <div class="bg-white p-6 rounded-2xl shadow-md mb-10">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Cadastrar novo presente</h2>
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Funcionário</label>
                    <select class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option value="">Selecione...</option>
                        <option>Lucas</option>
                        <option>Ana</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Presente</label>
                    <input type="text" placeholder="Ex: Caixa de chocolate" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor (R$)</label>
                    <input type="number" step="0.01" placeholder="Ex: 50.00" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200">
                </div>

                <div class="md:col-span-3 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition">Cadastrar</button>
                </div>
            </form>
        </div>

        <!-- Tabela de presentes -->
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Lista de Presentes</h2>
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-blue-50 text-blue-800">
                        <th class="py-2 px-3 text-left">Funcionário</th>
                        <th class="py-2 px-3 text-left">Presente</th>
                        <th class="py-2 px-3 text-left">Valor</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-2 px-3">Lucas</td>
                        <td class="py-2 px-3">Caneca personalizada</td>
                        <td class="py-2 px-3">R$ 40,00</td>
                        <td class="py-2 px-3"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span></td>
                        <td class="py-2 px-3 text-center space-x-2">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Pago</button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Excluir</button>
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2 px-3">Ana</td>
                        <td class="py-2 px-3">Buquê de flores</td>
                        <td class="py-2 px-3">R$ 60,00</td>
                        <td class="py-2 px-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Pago</span></td>
                        <td class="py-2 px-3 text-center space-x-2">
                            <button class="bg-gray-400 text-white px-3 py-1 rounded-lg text-sm cursor-not-allowed" disabled>Pago</button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</body>

</html>