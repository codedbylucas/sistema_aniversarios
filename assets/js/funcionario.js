listarFuncionario()

function limparFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.querySelectorAll('input').forEach(input => {
        const type = input.type.toLowerCase();
        if (type === 'text' || type === 'date' || type === 'hidden' || type === 'tel' || type === 'number') {
            input.value = '';
        }
    });
}

function deletarFuncionario(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Essa ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`../controller/FuncionarioController.php?acao=deletar&id=${id}`, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.sucesso) {
                        listarFuncionario()
                        Swal.fire('Deletado!', data.mensagem, 'success');
                    } else {
                        Swal.fire('Alerta!', data.mensagem, 'error');
                    }

                }).catch(error => {
                    console.error('Erro ao deletar:', error);
                    Swal.fire('Erro', 'Não foi possível excluir o funcionário.', 'error');
                });

        }
    })
}

function cadastrarFuncionario() {
    const nome = document.getElementById('nome').value;
    const cargo = document.getElementById("cargo").value;
    const whatsapp = document.getElementById("whatsapp").value;
    const data_nascimento = document.getElementById("data_nascimento").value;

    const formData = new FormData();
    formData.append('nome', nome)
    formData.append('cargo', cargo)
    formData.append('whatsapp', whatsapp)
    formData.append('data_nascimento', data_nascimento)

    fetch('../controller/FuncionarioController.php?acao=cadastrar', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                fecharModalCadastrar()
                listarFuncionario();
                Swal.fire("Sucesso", data.mensagem, "success");
            } else {
                Swal.fire("Erro", data.mensagem, "error");
            }
        })
        .catch(error => {
            console.error("Erro ao atualizar:", error);
            Swal.fire("Erro", "Erro inesperado ao atualizar funcionário", "error");
        });

}

function atualizarFuncionario() {
    //limparFormulario('formEditarFuncionario');
    const id = document.getElementById("editarId").value;
    const nome = document.getElementById("editarNome").value;
    const cargo = document.getElementById("editarCargo").value;
    const whatsapp = document.getElementById("editarWhatsapp").value;
    const data_nascimento = document.getElementById("editarDataNascimento").value;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("cargo", cargo);
    formData.append("whatsapp", whatsapp);
    formData.append("data_nascimento", data_nascimento);

    fetch('../controller/FuncionarioController.php?acao=atualizar', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                limparFormulario('formEditarFuncionario');
                fecharModalEditar()
                listarFuncionario();
                Swal.fire("Sucesso", data.mensagem, "success");

            } else {
                Swal.fire("Erro", data.mensagem, "error");
            }
        })
        .catch(error => {
            console.error("Erro ao atualizar:", error);
            Swal.fire("Erro", "Erro inesperado ao atualizar funcionário", "error");
        });
}


function editarFuncionario(id) {

    fetch(`../controller/FuncionarioController.php?acao=editar&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.erro) {
                Swal.fire("Erro", data?.erro || "Erro ao carregar dados.", "error");
                return;
            }
            abrirModalEditar()
            // Exemplo: preenche o modal de edição
            document.getElementById("editarId").value = data.id
            document.getElementById("editarNome").value = data.nome;
            document.getElementById("editarCargo").value = data.cargo;
            document.getElementById("editarWhatsapp").value = data.whatsapp;
            document.getElementById("editarDataNascimento").value = data.data_nascimento;

            //limparFormulario('formEditarFuncionario');

        })
        .catch(err => {
            console.error("Erro ao buscar funcionário:", err);
            Swal.fire("Erro", "Não foi possível buscar os dados.", "error");
        });
}


function listarFuncionario() {
    fetch('../controller/FuncionarioController.php?acao=listar')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(funcionarios => {

            const tbody = document.querySelector('#tabela-funcionarios');

            tbody.innerHTML = ''; // Limpa a tabela antes de recriar

            // Garante que o retorno é um array
            if (!Array.isArray(funcionarios)) {
                console.warn("O retorno não é um array. Corrigindo estrutura...");
                funcionarios = [funcionarios];
            }

            if (funcionarios[0].erro) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Nenhum funcionário encontrado
                        </td>
                    </tr>
                `;
                return;
            }

            funcionarios.forEach(f => {
                const tr = document.createElement('tr');
                // tr.id = `linha-${f.id}`; // <--- ID da linha
                tr.classList.add('border-b', 'hover:bg-blue-50');

                tr.innerHTML = `
                    <td class="py-3 px-4">#${f.id}</td>
                    <td class="py-3 px-4 nome">${f.nome}</td>
                    <td class="py-3 px-4 cargo">${f.cargo}</td>
                    <td class="py-3 px-4 whatsapp">${f.whatsapp}</td>
                    <td class="py-3 px-4 data_nascimento">${f.data_nascimento}</td>
                    <td class="py-3 px-4 flex gap-2">
                        <button onclick="editarFuncionario(${f.id})"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded-lg text-sm">
                            Editar
                        </button>
                        <button onclick="deletarFuncionario(${f.id})"
                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg text-sm">
                            Excluir
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Erro ao atualizar tabela:', error);
        });
}

function abrirModalCadastrar() {
    document.getElementById('modal').classList.remove('hidden');
    limparFormulario('formFuncionario');
}

function fecharModalCadastrar() {
    document.getElementById('modal').classList.add('hidden');
    limparFormulario('formFuncionario');
}

function abrirModalEditar() {
    document.getElementById('modalEditar').classList.remove('hidden');
}

function fecharModalEditar() {
    document.getElementById('modalEditar').classList.add('hidden');
    limparFormulario('formEditarFuncionario');
}