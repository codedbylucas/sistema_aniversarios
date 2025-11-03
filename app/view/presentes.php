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
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php'; ?>

    <main class="flex-1 ml-64 p-10 overflow-y-auto">


        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-700">Controle de Presentes</h2>
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
                        <th class="py-3 px-4 text-left rounded-tl-lg">Data Cadastro</th>
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
    <div id="modal-cadastro" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 animate-fadeInUp relative">

            <!-- Botão fechar -->
            <button onclick="fecharModalCadastro()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl transition-all">
                ✖
            </button>

            <!-- Cabeçalho -->
            <h3 class="text-2xl font-bold text-blue-600 mb-6 text-center">Cadastrar Presente</h3>

            <!-- Formulário -->
            <form id="form-cadastrar-presente" class="space-y-5">
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Presente</label>
                    <input type="text" id="descricao-presente" name="descricao" required placeholder="Ex: Caixa de chocolate"
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Valor Total (R$)</label>
                    <input type="number" id="valor_total" name="valor_total" required step="0.01" placeholder="Ex: 50.00"
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Funcionários Participantes</label>
                    <select id="funcionarios" name="funcionarios[]" multiple required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none h-32 transition">
                        <!-- Opções preenchidas via JS -->
                    </select>
                    <small class="text-gray-500">Segure Ctrl (ou Cmd) para selecionar múltiplos.</small>
                </div>

                <input type="button" onclick="cadastrarPresente()"
                    class="w-full group relative inline-flex items-center justify-center px-4 py-3 
                    font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600
                    transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="Cadastrar">
            </form>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div id="modalDetalhes" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform scale-95 opacity-0 animate-fadeInUp">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-blue-700">Detalhes do Presente</h2>
                <button onclick="fecharModalDetalhes()" class="text-gray-400 hover:text-gray-700 transition">
                    ✖
                </button>
            </div>

            <!-- Corpo -->
            <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
                <div id="detalhesPresente" class="text-gray-700 text-lg leading-relaxed space-y-2"></div>

                <div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-3">Participantes</h3>
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                        <thead class="bg-blue-100 text-blue-700">
                            <tr>
                                <th class="py-2 px-4 text-left">Nome</th>
                                <th class="py-2 px-4 text-center">Status</th>
                                <th class="py-2 px-4 text-center">Valor</th>
                                <th class="py-2 px-4 text-center">Ação</th>
                                <th class="py-2 px-4 text-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody id="listaParticipantes" class="bg-white"></tbody>
                    </table>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="flex justify-end items-center gap-4 px-6 py-4 border-t border-gray-200">
                <button onclick="fecharModalDetalhes()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-xl transition-all duration-300">
                    Fechar
                </button>
            </div>
        </div>
    </div>


</body>

</html>