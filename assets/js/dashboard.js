relatorioDash()

function relatorioDash() {

    fetch('../controller/DashBoardController.php?acao=getFuncionarios')
        .then(response => response.json())
        .then(data => {
            console.log(data)

            const divPai = document.getElementById('card-relatorio')

            divPai.innerHTML = `
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                        <h3 class="text-lg font-semibold text-blue-600 mb-2">Funcionários Cadastrados</h3>
                        <p class="text-4xl font-bold text-blue-700">${data.funcionarios}</p>
                    </div> 

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                         <h3 class="text-lg font-semibold text-blue-600 mb-2">Presentes Pagos</h3>
                        <p class="text-4xl font-bold text-blue-700">${data.presentes}</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition">
                       <h3 class="text-lg font-semibold text-blue-600 mb-2">Aniversariantes do Mês</h3>
                       <p class="text-4xl font-bold text-blue-700">${data.aniversariantes_mes}</p>
                    </div>
                        
                `

        })
        .catch(error => {
            console.error('Erro ao atualizar tabela:', error);
        });
}

