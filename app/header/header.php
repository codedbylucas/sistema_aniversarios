<!-- Barra lateral moderna -->
<aside class="w-64 h-screen fixed left-0 top-0 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-2xl flex flex-col justify-between p-6 transition-all duration-500 ease-in-out group overflow-y-auto">
    <div>
        <!-- Logo / título -->
        <h1 class="text-2xl font-extrabold tracking-wide mb-10 text-center">
            🎉 Aniversários
        </h1>

        <!-- Navegação -->
        <nav class="space-y-3">
            <a href="dashboard.php" class="flex items-center gap-3 text-white/90 font-medium px-4 py-2 rounded-lg hover:bg-blue-500/40 hover:translate-x-1 transition-all duration-300">
                <i class="fa-solid fa-house"></i>
                <span>Início</span>
            </a>
            <a href="funcionarios.php" class="flex items-center gap-3 text-white/90 font-medium px-4 py-2 rounded-lg hover:bg-blue-500/40 hover:translate-x-1 transition-all duration-300">
                <i class="fa-solid fa-users"></i>
                <span>Funcionários</span>
            </a>
            <a href="presentes.php" class="flex items-center gap-3 text-white/90 font-medium px-4 py-2 rounded-lg hover:bg-blue-500/40 hover:translate-x-1 transition-all duration-300">
                <i class="fa-solid fa-gift"></i>
                <span>Presentes</span>
            </a>
            <a href="relatorios.php" class="flex items-center gap-3 text-white/90 font-medium px-4 py-2 rounded-lg hover:bg-blue-500/40 hover:translate-x-1 transition-all duration-300">
                <i class="fa-solid fa-chart-line"></i>
                <span>Relatórios</span>
            </a>
        </nav>
    </div>

    <!-- Rodapé / perfil -->
    <div class="border-t border-white/20 pt-4 mt-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-lg font-semibold">
                <?= strtoupper(substr($_SESSION['nome'], 0, 1)); ?>
            </div>
            <div>
                <p class="text-sm text-white/70">Logado como:</p>
                <p class="font-semibold"><?= $_SESSION['nome']; ?></p>
            </div>
        </div>
        <a href="../controller/AutenticacaoController.php?acao=sair"
           class="block text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg transition-all duration-300 hover:scale-105 shadow-md">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>Sair
        </a>
    </div>
</aside>

<!-- Importar ícones FontAwesome -->

