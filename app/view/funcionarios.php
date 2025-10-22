<?php
session_start();
require_once __DIR__ . '/../controller/AutenticacaoController.php';
require_once __DIR__ . '/../dao/FuncionarioDAO.php';
require_once __DIR__ . '/../config/DBConnection.php';

if (AutenticacaoController::validarAcesso() === false) {
    AutenticacaoController::encerrarSessao();
}

$db = new DBConnection();
$pdo = $db->getConnection();
$funcionarioDAO = new FuncionarioDAO($pdo);
$lista = $funcionarioDAO->buscarTodos();


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Funcionários | Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body class="bg-blue-50 min-h-screen flex">

    <?php require '../header/header.php'; ?>


    <!-- Conteúdo principal -->
    <main class="flex-1 p-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-blue-700">👥 Funcionários</h2>
            <button onclick="abrirModal()"
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
                        <th class="py-3 px-4 text-left rounded-tl-lg">Nome</th>
                        <th class="py-3 px-4 text-left">Cargo</th>
                        <th class="py-3 px-4 text-left">WhatsApp</th>
                        <th class="py-3 px-4 text-left">Data de Nascimento</th>
                        <th class="py-3 px-4 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-funcionarios">
                    <!-- Exemplo de funcionário -->
                    <?php foreach ($lista as $dados) : ?>
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-3 px-4">#<?= $dados->getId() ?></td>
                            <td class="py-3 px-4"><?= $dados->getNome() ?></td>
                            <td class="py-3 px-4"><?= $dados->getCargo() ?></td>
                            <td class="py-3 px-4"><?= $dados->getWhatsapp() ?></td>
                            <td class="py-3 px-4"><?= $dados->getDataNascimento() ?></td>
                            <td class="py-3 px-4 flex gap-2">
                                <button onclick="editarFuncionario('')" class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded-lg text-sm">Editar</button>
                                <a href="../../app/controller/FuncionarioController.php?id=<?= $dados->getId() ?>" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg text-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        if (isset($_GET['mensagem'])) {
            echo "<div id='mensagem-alerta' class='mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg'>
            {$_GET['mensagem']}
          </div>";
        }
        ?>
    </main>

    <!-- Modal de cadastro -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-lg relative">
            <button onclick="fecharModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h3 class="text-2xl font-bold text-blue-600 mb-6 text-center">Cadastrar Funcionário</h3>

            <form id="formFuncionario" method="POST" action="../../app/controller/FuncionarioController.php" class="space-y-5">
                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Nome</label>
                    <input type="text" name="nome" required placeholder="Nome completo"
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Cargo</label>
                    <input type="text" name="cargo" required placeholder="Ex: Financeiro, Logística..."
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" required placeholder="Ex: 44999567884"
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-blue-700 font-semibold mb-2">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required
                        class="w-full p-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit" name="cadastrar"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition">
                    Salvar Funcionário
                </button>
            </form>
        </div>
    </div>

    <script>
        function abrirModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function fecharModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>

    <script src="../../assets/js/script.js"></script>

</body>

</html>