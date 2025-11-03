<?php
session_start();
require_once __DIR__ . '/../controller/AutenticacaoController.php';
require_once __DIR__ . '/../dao/FuncionarioDAO.php';
require_once __DIR__ . '/../config/DBConnection.php';

if (AutenticacaoController::validarAcesso() === false) {
    AutenticacaoController::encerrarSessao();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Funcionários | Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/funcionario.js"></script>
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

    <!-- Barra lateral fixa -->
    <?php require '../header/header.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 ml-64 p-10 overflow-y-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-700">Funcionários</h2>
            <button
                onclick="abrirModalCadastrar()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition">
                + Adicionar Funcionário
            </button>
        </div>

        <!-- Tabela de funcionários -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-700">
                        <th class="py-3 px-4 text-left rounded-tl-lg">ID</th>
                        <th class="py-3 px-4 text-left">Nome</th>
                        <th class="py-3 px-4 text-left">Cargo</th>
                        <th class="py-3 px-4 text-left">WhatsApp</th>
                        <th class="py-3 px-4 text-left">Data de Nascimento</th>
                        <th class="py-3 px-4 text-left rounded-tr-lg">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-funcionarios">
                    <!-- Preenchido via JavaScript -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Cadastro -->
    <div id="modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 animate-fadeInUp relative">
            <!-- Botão fechar -->
            <button onclick="fecharModalCadastrar()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl transition-all">
                ✖
            </button>

            <!-- Cabeçalho -->
            <h3 class="text-2xl font-bold text-blue-600 mb-6 text-center">Cadastrar Funcionário</h3>

            <!-- Formulário -->
            <form id="formFuncionario" class="space-y-5">
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Nome</label>
                    <input type="text" id="nome" name="nome" required placeholder="Nome completo"
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Cargo</label>
                    <input type="text" id="cargo" name="cargo" required placeholder="Ex: Financeiro, Logística..."
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" required placeholder="Ex: 44999567884"
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>

                <input type="button" onclick="cadastrarFuncionario()"
                    class="w-full group relative inline-flex items-center justify-center px-4 py-3 
                    font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600
                    transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="Cadastrar">
            </form>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div id="modalEditar" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 transform scale-95 opacity-0 animate-fadeInUp relative">
            <button onclick="fecharModalEditar()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl transition-all">
                ✖
            </button>

            <h3 class="text-2xl font-bold text-blue-600 mb-6 text-center">Editar Funcionário</h3>

            <form id="formEditarFuncionario" class="space-y-5">
                <input type="hidden" id="editarId">

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Nome</label>
                    <input type="text" name="nome" id="editarNome" required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Cargo</label>
                    <input type="text" name="cargo" id="editarCargo" required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" id="editarWhatsapp" required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="editarDataNascimento" required
                        class="w-full p-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                </div>

                <input type="button" onclick="atualizarFuncionario()"
                    class="w-full group relative inline-flex items-center justify-center px-4 py-3 
                    font-semibold rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600
                    transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="Atualizar">
            </form>
        </div>
    </div>

</body>

</html>