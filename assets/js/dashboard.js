relatorioDash();

function relatorioDash() {

    fetch('../controller/DashBoardController.php?acao=relatorioDash')
        .then(response => response.json())
        .then(data => {

            const divCards = document.getElementById('card-relatorio');

            divCards.innerHTML = `
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Funcionários Cadastrados</h3>
                    <p class="text-4xl font-bold text-blue-800">${data[0].funcionarios}</p>
                </div>

                <div class="bg-gradient-to-br from-green-100 to-green-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold text-green-700 mb-2">Presentes Pagos</h3>
                    <p class="text-4xl font-bold text-green-800">${data[0].presentes}</p>
                </div>

                <div class="bg-gradient-to-br from-red-100 to-red-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold text-red-700 mb-2">Aniversariantes do Mês</h3>
                    <p class="text-4xl font-bold text-red-800">${data[0].aniversariantes_mes.length}</p>
                </div>
            `;

            const tbody = document.getElementById('tabela-aniversario');
            tbody.innerHTML = '';

            if (!Array.isArray(data)) {
                console.warn("O retorno não é um array. Corrigindo estrutura...");
                data = [data];
            }

            if (!data[0].aniversariantes_mes || data[0].aniversariantes_mes.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Nenhum aniversariante encontrado.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(d => {
                d.aniversariantes_mes.forEach(a => {
                    const tr = document.createElement('tr');
                    tr.classList.add('hover:bg-blue-50', 'transition', 'duration-200');

                    tr.innerHTML = `
                        <td class="py-3 px-4 font-medium">${a.nome}</td>
                        <td class="py-3 px-4">${formatarData(a.data_nascimento)}</td>
                        <td class="py-3 px-4">${a.cargo}</td>
                        <td class="py-3 px-4 flex justify-center">
                            <button onclick="Swal.fire('Parabéns!', 'Lembrete enviado para o ADM!', 'success')"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 
                                text-white font-semibold px-4 py-2 rounded-xl shadow-lg hover:shadow-xl 
                                transition-transform duration-300 transform hover:scale-105">
                                Enviar Lembrete
                            </button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });
            });

        })
        .catch(error => {
            console.error('Erro ao atualizar tabela:', error);
            const tbody = document.getElementById('tabela-aniversario');
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-red-500">
                        Erro ao carregar dados.
                    </td>
                </tr>
            `;
        });
}

function formatarData(iso) {
    const data = new Date(iso);
    const dia = String(data.getDate() + 1).padStart(2, '0');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}
