relatorioDash()

function relatorioDash() {

    fetch('../controller/DashBoardController.php?acao=relatorioDash')
        .then(response => response.json())
        .then(data => {

            const divCards = document.getElementById('card-relatorio')

            divCards.innerHTML = `
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                        <h3 class="text-lg font-semibold text-blue-600 mb-2">Funcionários Cadastrados</h3>
                        <p class="text-4xl font-bold text-blue-700">${data[0].funcionarios}</p>
                    </div> 

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                         <h3 class="text-lg font-semibold text-blue-600 mb-2">Presentes Pagos</h3>
                        <p class="text-4xl font-bold text-blue-700">${data[0].presentes}</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                       <h3 class="text-lg font-semibold text-blue-600 mb-2">Aniversariantes do Mês</h3>
                       <p class="text-4xl font-bold text-blue-700">${data[0].aniversariantes_mes.length}</p>
                    </div>
                        
                `

            const tbody = document.getElementById('tabela-aniversario')

            tbody.innerHTML = '';

            // Garante que o retorno é um array
            if (!Array.isArray(data)) {
                console.warn("O retorno não é um array. Corrigindo estrutura...");
                data = [data];
            }

            console.log(data[0].aniversariantes_mes)

            if (!data[0].aniversariantes_mes) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Nenhum aniversariante encontrado.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(d => {

                d.aniversariantes_mes.forEach(a => {
                    console.log(a)

                    const tr = document.createElement('tr');
                    tr.classList.add('border-b', 'hover:bg-blue-50');

                    tr.innerHTML = `
                        <td class="py-3 px-4">${a.nome}</td>
                        <td class="py-3 px-4">${formatarData(a.data_nascimento)}</td>
                        <td class="py-3 px-4">${a.cargo}</td>
                        <td class="py-3 px-4">
                            <button onclick="Swal.fire('Parabéns!', 'Lembrete enviado para o grupo!', 'success')"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg text-sm">
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
        });
}

function formatarData(iso) {
    const data = new Date(iso);
    const dia = String(data.getDate() + 1).padStart(2, '1');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}

