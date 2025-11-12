function cadastrarUsuario() {

    const nome = document.getElementById('nome').value;
    const senha = document.getElementById("senha").value;
    const email = document.getElementById("email").value;

    const formData = new FormData();
    formData.append('nome', nome)
    formData.append('senha', senha)
    formData.append('email', email)

    fetch('../controller/CadastroController.php?acao=cadastrar', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const divMensagem = document.querySelector('#mensagem-alerta')

            divMensagem.innerHTML = ''

            if (data.success) {
                divMensagem.className = 'mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            } else {
                divMensagem.className = 'mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            }
            divMensagem.innerHTML = data.mensagem;
        })


}

function efetuarLogin() {

    const email = document.getElementById('email').value
    const senha = document.getElementById('senha').value

    const formData = new FormData()
    formData.append('email', email)
    formData.append('senha', senha)

    fetch('../controller/UsuarioController.php?acao=login', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin' // garante envio/recebimento de cookies (sessão)
    })
        .then(response => response.json())
        .then(data => {
            const divMensagem = document.getElementById('mensagem-alerta');

            if (data.success) {
                // redireciona para o dashboard informado pelo servidor
                window.location.href = data.redirect ?? '../view/dashboard.php';
            } else {
                divMensagem.className = 'mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
                if (divMensagem) {
                    divMensagem.textContent = data.message || 'Erro no login';
                } else {
                    divMensagem.textContent = data.message || 'Erro no login';
                }
            }
        })
        .catch(err => {
            console.error('Erro na requisição:', err);
            alert('Erro ao conectar com o servidor.');
        });
}