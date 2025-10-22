<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login | Sistema de Aniversários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body class="bg-blue-100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-3xl w-full max-w-md p-10">
        <!-- Título -->
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Bem-vindo</h1>

        <!-- Formulário de Login -->
        <form method="POST" action="../../app/controller/UsuarioController.php" class="space-y-6">
            <div>
                <label class="block text-blue-700 font-semibold mb-2">E-mail</label>
                <input type="email" name="email" placeholder="Digite seu e-mail" required
                    class="w-full p-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-blue-700 font-semibold mb-2">Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha" required
                    class="w-full p-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit" name="login"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition">
                Entrar
            </button>
        </form>
        <?php
        if (isset($_GET['mensagem'])) {
            echo "<div class='mt-4 p-4 bg-red-100 border border-green-400 text-green-700 rounded-lg'>
            {$_GET['mensagem']}
          </div>";
        }

        if (isset($_GET['erro'])) {
            echo "<div class='mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg'>
            {$_GET['erro']}
          </div>";
        }
        ?>

        <!-- Divisor -->
        <div class="flex items-center my-6">
            <hr class="flex-grow border-t border-blue-200">
            <span class="px-4 text-blue-400 font-medium">ou</span>
            <hr class="flex-grow border-t border-blue-200">
        </div>

        <!-- Botão de Cadastro -->
        <a href="cadastrar.php"
            class="block w-full text-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-3 rounded-lg transition">
            Criar nova conta
        </a>

    </div>

</body>

</html>