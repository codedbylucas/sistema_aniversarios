<!-- Menu lateral -->
<aside class="w-64 bg-white shadow-xl flex flex-col justify-between p-6">
    <div>
        <h1 class="text-2xl font-bold text-blue-600 mb-8">Aniversários</h1>
        <nav class="space-y-4">
            <a href="dashboard.php" class="block text-blue-700 font-semibold hover:text-blue-500">Início</a>
            <a href="funcionarios.php" class="block text-blue-700 font-semibold hover:text-blue-500">Funcionários</a>
            <a href="presentes.php" class="block text-blue-700 font-semibold hover:text-blue-500">Presentes</a>
            <a href="relatorios.php" class="block text-blue-700 font-semibold hover:text-blue-500">Relatórios</a>
        </nav>
    </div>

    <div class="border-t border-blue-200 pt-4">
        <p class="text-sm text-gray-500 mb-2">Logado como:</p>
        <p class="font-semibold text-blue-600 mb-4"><?= $_SESSION['nome']; ?></p>
        <a href="../controller/AutenticacaoController.php?acao=sair"
            class="block text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition">Sair</a>
    </div>
</aside>