/* Controle das abas da página Educação Infantil */

document.addEventListener("DOMContentLoaded", () => {

    function abrirAba(evt, aba) {
        evt.preventDefault();

        // remove active de todos
        document.querySelectorAll(".tabcontent").forEach(el =>
            el.classList.remove("active")
        );

        document.querySelectorAll(".tablink").forEach(a =>
            a.classList.remove("active")
        );

        // ativa a aba desejada
        document.getElementById(aba).classList.add("active");
        evt.currentTarget.classList.add("active");
    }

    // adicionar evento automaticamente a todos os botões
    const botoes = document.querySelectorAll(".tablink");

    botoes.forEach(botao => {
        const alvo = botao.dataset.aba; // <-- AGORA FUNCIONA

        botao.addEventListener("click", function (event) {
            abrirAba(event, alvo);
        });
    });
});
