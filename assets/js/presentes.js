buscarParticipantes();
listarPresentes();

function limparFormulario() {
    document.getElementById('descricao-presente').value = '';
    document.getElementById('valor_total').value = '';
    document.getElementById('funcionarios').selectedIndex = -1;
}

function buscarParticipantes() {
    fetch('../controller/PresenteController.php?acao=participantes')
        .then(response => response.json())
        .then(data => {
            const funcionarios = data[0];
            const select = document.getElementById('funcionarios');
            select.innerHTML = '';

            funcionarios.forEach(participante => {
                const option = document.createElement('option');
                option.value = participante.id;
                option.textContent = participante.nome;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erro ao buscar participantes:', error);
        });
}

function cadastrarPresente() {

    const descricao = document.getElementById('descricao-presente').value;
    const valor = document.getElementById('valor_total').value;
    const select = document.getElementById('funcionarios');

    const funcionariosSelecionados = Array.from(select.selectedOptions).map(opt => opt.value);

    const formData = new FormData();
    formData.append('descricao', descricao);
    formData.append('valor', valor);
    formData.append('funcionarios', JSON.stringify(funcionariosSelecionados));

    if (formData) {
        Swal.fire('Atenção', 'Preencha todos os campos!', 'warning');
    }

    fetch('../controller/PresenteController.php?acao=cadastrar', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fecharModalCadastro();
                listarPresentes();
                Swal.fire('Sucesso', 'Presente cadastrado com sucesso!', 'success');
            } else {
                alert('Erro ao cadastrar presente: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao cadastrar presente:', error);
        });

}

function listarPresentes() {
    fetch('../controller/PresenteController.php?acao=listar')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(presentes => {
            console.log(presentes)
            const tbody = document.querySelector('#tabela-presentes');
            if (!tbody) {
                console.error("Elemento #tabela-funcionarios não encontrado na página.");
                return;
            }

            tbody.innerHTML = ''; // Limpa a tabela antes de recriar

            // Garante que o retorno é um array
            if (!Array.isArray(presentes)) {
                console.warn("O retorno não é um array. Corrigindo estrutura...");
                presentes = [presentes];
            }

            if (presentes.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Nenhum funcionário encontrado
                        </td>
                    </tr>
                `;
                return;
            }

            presentes.forEach(presente => {
    const tr = document.createElement('tr');
    tr.id = `linha-${presente.id}`;
    tr.classList.add('border-b', 'hover:bg-blue-50');

    // Status geral
    const statusPago = presente.status === "pago"
        ? `<span class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Pago</span>`
        : `<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span>`;

    // Botões de ação
    const btnDetalhes = `<button onclick="abrirDetalhes(${presente.id})"
        class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-sm">
        Detalhes
    </button>`;
    const btnExcluir = `<button onclick="excluirPresente(${presente.id})"
        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg text-sm">
        Excluir
    </button>`;

    tr.innerHTML = `
    <td class="py-3 px-4">#${presente.id}</td>
    <td class="py-3 px-4 descricao">${presente.descricao}</td>
    <td class="py-3 px-4 valor">R$ ${parseFloat(presente.valor_total).toFixed(2)}</td>
    <td class="py-3 px-4 status">${statusPago}</td>
    <td class="py-3 px-4 flex items-center gap-2">
        ${btnDetalhes}
        ${btnExcluir}
    </td>
`;

    tbody.appendChild(tr);
});

        })
}

function abrirModalCadastro() {
    document.getElementById('modal-cadastro').classList.remove('hidden');
}

function fecharModalCadastro() {
    document.getElementById('modal-cadastro').classList.add('hidden');
    limparFormulario();
}