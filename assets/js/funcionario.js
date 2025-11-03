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
                        Swal.fire('Alerta!', data.mensagem, 'warning');
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
                Swal.fire("Alerta", data.erro, "warning");
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
                Swal.fire("Erro", data.mensagem, "warning");
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
                    <td class="py-3 px-4 data_nascimento">${formatarData(f.data_nascimento)}</td>
                    <td class="py-3 px-4 flex gap-2">
                        <button onclick="editarFuncionario(${f.id})"
                            class="group relative inline-flex items-center justify-center px-4 py-2 
                                    overflow-hidden font-semibold rounded-xl text-white 
                                    bg-gradient-to-r from-blue-500 to-blue-600
                                    transition-all duration-300 hover:shadow-lg hover:scale-105
                                    focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                            <span class="absolute inset-0 w-full h-full bg-blue-400 opacity-0 group-hover:opacity-20 transition-opacity"></span>
                            <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" 
                                viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/>
                            </svg>
                            Editar
                        </button>
                        <button onclick="deletarFuncionario(${f.id})"
                            class="group relative inline-flex items-center justify-center px-4 py-2 
                                    overflow-hidden font-semibold rounded-xl text-white 
                                    bg-gradient-to-r from-red-500 to-red-600
                                    transition-all duration-300 hover:shadow-lg hover:scale-105
                                    focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                            <span class="absolute inset-0 w-full h-full bg-red-400 opacity-0 group-hover:opacity-20 transition-opacity"></span>
                            <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" 
                                viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
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

function formatarData(iso) {
    const data = new Date(iso);
    const dia = String(data.getDate() + 1).padStart(2, '1');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}
