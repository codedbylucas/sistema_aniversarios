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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/presentes.js "></script>
</head>

<body class="bg-slate-100 min-h-screen flex">

    <?php require '../header/header.php'; ?>

    <main class="flex-1 p-10">

        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-700">🎁 Controle de Presentes</h2>
            <button
                onclick="abrirModalCadastro()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition">
                + Cadastrar Presente
            </button>
        </div>

        

        <!-- Tabela de funcionários -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-3 px-4 text-left rounded-tl-lg">ID</th>
                        <th class="py-3 px-4 text-left rounded-tl-lg">Presente</th>
                        <th class="py-3 px-4 text-left">Valor Total</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>

                <tbody id="tabela-presentes">
                    <!-- Preenchido via JS -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Cadastro de Presente -->
    <div id="modal-cadastro" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg relative">
            <button onclick="fecharModalCadastro()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h3 class="text-2xl font-bold text-blue-600 mb-6 text-center">Cadastrar Presente</h3>

            <form id="form-cadastrar-presente" class="space-y-5">
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Presente</label>
                    <input type="text" id="descricao-presente" name="descricao" required placeholder="Ex: Caixa de chocolate"
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Valor Total (R$)</label>
                    <input type="number" id="valor_total" name="valor_total" required step="0.01" placeholder="Ex: 50.00"
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Funcionários Participantes</label>
                    <select id="funcionarios" name="funcionarios[]" multiple required
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400 h-32">
                        <!-- Opções preenchidas via JS -->
                    </select>
                    <small class="text-gray-500">Segure Ctrl (ou Cmd) para selecionar múltiplos.</small>
                </div>

                <input
                    onclick="cadastrarPresente()"
                    type="button"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition"
                    value="Cadastrar" />
            </form>
        </div>
    </div>


</body>

</html>