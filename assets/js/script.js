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
