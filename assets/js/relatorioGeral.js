listarTodosPresentes()

async function relatorioGeral() {
    const selectMes = document.getElementById('mes').value;
    const selectStatus = document.getElementById('status').value;

    try {
        const response = await fetch(`../controller/RelatorioGeralController.php?mes=${selectMes}&status=${selectStatus}`);
        const result = await response.json();

        document.getElementById('card').innerHTML = `
        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Presentes cadastrados</p>
            <h3 id="card-presentes" class="text-3xl font-bold text-blue-800">${result.totalPresentes}</h3>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Presentes pagos</p>
            <h3 id="card-pagos" class="text-3xl font-bold text-green-700">${result.totalPagos}</h3>
        </div>
        <div class="bg-gradient-to-br from-red-100 to-red-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Pendentes</p>
            <h3 id="card-pendentes" class="text-3xl font-bold text-red-700">${result.totalPendentes}</h3>
        </div>
    `;

        const tbody = document.querySelector('tbody');

        if (!result.dados || !result.dados.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhum presente encontrado.</td>
                </tr>
            `;
            return;
        }

        let linhas = '';
        result.dados.forEach(presente => {
            linhas += `
                <tr class="border-t">
                    <td class="py-2 px-3">${presente.participantes}</td>
                    <td class="py-2 px-3">${presente.descricao}</td>
                    <td class="py-2 px-3">${presente.valor_total}</td>
                    <td class="py-2 px-3">${formatarData(presente.data_cadastro)}</td>
                    <td class="py-2 px-3">
                        <span class="${presente.status === 'pago' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} px-3 py-1 rounded-full text-sm">
                            ${letraMaiuscula(presente.status)}
                        </span>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = linhas;

    } catch (error) {
        console.error('Erro ao buscar dados:', error);
        document.querySelector('tbody').innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4 text-red-500">Erro ao carregar dados.</td>
            </tr>
        `;
    }
}

function listarTodosPresentes() {
    fetch('../controller/RelatorioGeralController.php?acao=listar')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbody');
            tbody.innerHTML = '';

            document.getElementById('card').innerHTML = `
        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Presentes cadastrados</p>
            <h3 id="card-presentes" class="text-3xl font-bold text-blue-800">${data.totalPresentes}</h3>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-green-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Presentes pagos</p>
            <h3 id="card-pagos" class="text-3xl font-bold text-green-700">${data.totalPagos}</h3>
        </div>
        <div class="bg-gradient-to-br from-red-100 to-red-200 p-6 rounded-2xl shadow-lg text-center transform hover:scale-105 transition duration-300">
            <p class="text-gray-600 text-sm mb-1 font-medium">Pendentes</p>
            <h3 id="card-pendentes" class="text-3xl font-bold text-red-700">${data.totalPendentes}</h3>
        </div>
    `;

            if (!data) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhum presente encontrado.</td>
                </tr>
            `;
                return;
            }


            let linhas = '';
            data.dados.forEach(presente => {
                linhas += `
                <tr class="border-t">
                    <td class="py-2 px-3">${presente.participantes}</td>
                    <td class="py-2 px-3">${presente.descricao}</td>
                    <td class="py-2 px-3">${presente.valor_total}</td>
                    <td class="py-2 px-3">${formatarData(presente.data_cadastro)}</td>
                    <td class="py-2 px-3">
                        <span class="${presente.status === 'pago' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} px-3 py-1 rounded-full text-sm">
                            ${letraMaiuscula(presente.status)}
                        </span>
                    </td>
                </tr>
            `;
            });

            tbody.innerHTML = linhas;
        })
        .catch(error => {
            console.error('Erro ao buscar presentes:', error);
            const tbody = document.getElementById('tbody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4 text-red-500">
                        Erro ao carregar dados
                    </td>
                </tr>
            `;
        });
}

function letraMaiuscula(string) {
    // Retorna uma string vazia se a entrada for nula ou vazia
    if (!string) {
        return "";
    }
    // Converte a primeira letra para maiúscula e a concatena com o restante da string
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatarData(iso) {
    const data = new Date(iso);
    const dia = String(data.getDate() + 1).padStart(2, '1');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}
