<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Cadastrar | Sistema de Aniversários</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body class="bg-blue-100 flex justify-center items-center min-h-screen">

  <div class="bg-white shadow-2xl rounded-3xl w-full max-w-md p-10">
    <!-- Título -->
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">📝 Criar Conta</h1>

    <!-- Formulário de Cadastro -->
    <form method="POST" action="../../app/controller/CadastroController.php" class="space-y-6">
      <div>
        <label class="block text-blue-700 font-semibold mb-2">Nome</label>
        <input type="text" name="nome" placeholder="Digite seu nome" required
          class="w-full p-3 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

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

      <button type="submit" name="cadastrar"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition">
        Cadastrar
      </button>
    </form>

    <?php
    if (isset($_GET['mensagem'])) {
      echo "<div id='mensagem-alerta' class='mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg'>
            {$_GET['mensagem']}
          </div>";
    }
    ?>

    <!-- Link para Login -->
    <p class="mt-6 text-center text-blue-400">Já tem uma conta?
      <a href="login.php" class="hover:underline text-blue-600 font-semibold">Entrar</a>
    </p>

  </div>

  <script src="../../assets/js/script.js"></script>

</body>

</html>