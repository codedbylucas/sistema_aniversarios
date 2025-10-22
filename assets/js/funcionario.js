// Remove a mensagem de alerta após 3 segundos e limpa os parâmetros GET da URL
setTimeout(() => {
    const alerta = document.getElementById('mensagem-alerta');
    if (alerta) {
        alerta.style.transition = 'opacity 0.5s ease';
        alerta.style.opacity = '0';
        setTimeout(() => alerta.remove(), 500);
    }

    // Limpa a URL removendo os parâmetros GET
    const url = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, url);
}, 3000);

function editarFuncionario(id) {
    
    fetch(`../controller/FuncionarioController.php?acao=editar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.erro) {
                Swal.fire("Erro", data?.erro || "Erro ao carregar dados.", "error");
                return;
            }
            console.log(data);
            // Exemplo: preenche o modal de edição
            document.getElementById("editarNome").value = data.nome;
            document.getElementById("editarCargo").value = data.cargo;
            document.getElementById("editarWhatsapp").value = data.whatsapp;
            document.getElementById("editarDataNascimento").value = data.data_nascimento;

            // Abre o modal de edição
            document.getElementById("modalEditar").classList.remove("hidden");
        })
        .catch(err => {
            console.error("Erro ao buscar funcionário:", err);
            Swal.fire("Erro", "Não foi possível buscar os dados.", "error");
        });
}

function fecharModalEditar() {
    document.getElementById('modalEditar').classList.add('hidden');
}