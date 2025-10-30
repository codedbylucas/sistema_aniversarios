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
            const tbody = document.querySelector('#tabela-presentes');
            
            tbody.innerHTML = ''; // Limpa a tabela antes de recriar

            // Garante que o retorno é um array
            if (!Array.isArray(presentes)) {
                console.warn("O retorno não é um array. Corrigindo estrutura...");
                presentes = [presentes];
            }
            
            if (presentes[0].erro) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Nenhum presente encontrado
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
                    ? `<span class="bg-green-100 text-green-700 px-6 py-1 rounded-full text-sm">Pago</span>`
                    : `<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span>`;

                // Botões de ação
                const btnDetalhes = `<button onclick="abrirDetalhes(${presente.id})"
                    class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-sm">
                    Detalhes
                </button>`;
                const btnExcluir = `<button onclick="deletarPresente(${presente.id})"
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

function abrirDetalhes(idPresente) {

    fetch(`../controller/PresenteController.php?acao=detalhes&id=${idPresente}`)
        .then(response => response.json())
        .then(data => {
            const presente = data.presente;
            const participantes = data.participantes;
            const modal = document.getElementById('modalDetalhes');

            const detalhesDiv = document.getElementById("detalhesPresente");
            const tbody = document.getElementById("listaParticipantes");

            // Exibe os detalhes do presente
            detalhesDiv.innerHTML = `
                <p><strong>Presente:</strong> ${presente[0].descricao}</p>
                <p><strong>Valor total:</strong> R$ ${parseFloat(presente[0].valor_total).toFixed(2)}</p>
                <p><strong>Status geral:</strong> 
                    ${presente[0].status === "pago"
                        ? `<span class="bg-green-100 text-green-700 px-6 py-1 rounded-full text-sm">Pago</span>`
                        : `<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span>`}
                </p>
            `;

            // Limpa e preenche a tabela de participantes
            tbody.innerHTML = "";
            participantes.forEach(p => {
                const tr = document.createElement("tr");
                tr.classList.add("border-b", "hover:bg-blue-50");

                console.log(p);

                const statusBadge = p.status_pagamento === "Pago"
                    ? `<span class="bg-green-100 text-green-700 px-6 py-1 rounded-full text-sm">Pago</span>`
                    : `<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Pendente</span>`;

                const botao = p.status_pagamento === "Pago"
                    ? `<button disabled class="bg-gray-300 text-gray-600 px-3 py-1 rounded-full text-sm cursor-not-allowed">Pago</button>`
                    : `<button onclick="marcarComoPago(${p.id_relacao})" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Marcar Pago</button>`;

                tr.innerHTML = `
                    <td class="py-2 px-3">${p.nome}</td>
                    <td class="py-2 px-3 text-center">${statusBadge}</td>
                    <td class="py-2 px-3 text-center">R$ ${p.valor_contribuicao}</td>
                    <td class="py-2 px-3 text-center">${botao}</td>
                    <td class="py-2 px-3 text-center"> 
                    <button onclick="deletarParticipacao(${p.id_relacao})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Deletar</button>
                    </td>
                `;

                tbody.appendChild(tr);
            })

            modal.classList.remove('hidden');
            
        }).catch(error => console.error("Erro ao carregar detalhes:", error));

}

function marcarComoPago(idRelacao) {
    fetch(`../controller/PresenteController.php?acao=marcarPago&id_relacao=${idRelacao}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                listarPresentes();
                abrirDetalhes(data.id_presente);
                Swal.fire('Sucesso', 'Pagamento pago com sucesso!', 'success');
            } else {
                alert('Erro ao marcar pagamento: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao marcar pagamento:', error);
        });
}

function deletarParticipacao(id_relacao) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`../controller/PresenteController.php?acao=deletarParticipacao&id_relacao=${id_relacao}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    listarPresentes();
                    abrirDetalhes(data.id_presente);
                } else {
                    alert('Erro ao deletar participação: ' + data.message);
                }
            })
            Swal.fire(
                'Deletado!',
                'A participação foi deletada.',
                'success'
            );
        }
    });
}

function deletarPresente(idPresente) {
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
            fetch(`../controller/PresenteController.php?acao=deletarPresente&id=${idPresente}`)
                .then(response => response.json())
                .then(data => {

                    if (data.success) {
                        listarPresentes();
                        Swal.fire('Presente Deletado!', data.mensagem, 'success');
                    } else {
                        Swal.fire('Alerta!', 'Para deletar, remova os participantes do presente', 'error')
                    }

                }).catch(error => {
                    console.error('Erro ao deletar:', error);
                    Swal.fire('Erro', 'Não foi possível excluir o presente.', 'error');
                });

        }
    })
}

function fecharModalDetalhes() {
    document.getElementById('modalDetalhes').classList.add('hidden');
}

function abrirModalCadastro() {
    document.getElementById('modal-cadastro').classList.remove('hidden');
}

function fecharModalCadastro() {
    document.getElementById('modal-cadastro').classList.add('hidden');
    limparFormulario();
}